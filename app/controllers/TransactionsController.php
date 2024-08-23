<?php

declare(strict_types=1);

namespace app\controllers;

use app\core\Formatter;
use app\core\View;
use app\models\Transaction;

class TransactionsController
{
    public function index(array $externalParam = []): string
    {
        $transactionModel = new Transaction();
        $transactions = $transactionModel->selectAll();
        $totalValues = $transactionModel->getTotalValues($transactions);
        
        $param =  [
            'transactions' => $transactions,
            'totalValues' => $totalValues
        ];
        if (isset($_GET['message'])) {
            $_GET['message'] = htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8');
            $param  = array_merge($param, $_GET);
        }

        $param  = array_merge($param, $externalParam);

        return View::make('transactions', $param);
    }

    public function updateForm(): string
    {
        $transactionModel = new Transaction();
        $transactions = $transactionModel->selectAll();
        return View::make('updateForm', ['transactions' => $transactions]);
    }

    public function update(): void
    {
        if (isset($_POST['ids'])) {
            $transactionModel = new Transaction();
            $transactionModel->updateTransactionsInDB($_POST);
            http_response_code(301);
            $message = "Transactions successfully updated!";
            header("Location: /transactions?message=" . urlencode($message));
            exit;
        }
    }

    public function deleteForm(): string
    {
        $transactionModel = new Transaction();
        $transactions = $transactionModel->selectAll();
        return View::make('deleteForm', ['transactions' => $transactions]);
    }

    public function delete(): void
    {
        if (isset($_POST['transaction_ids']) && !empty($_POST['transaction_ids'])) {
            $transactionModel = new Transaction();
            $transactionModel->deleteTransactionsFromDB($_POST['transaction_ids']);
            http_response_code(301);
            $message = "Transactions successfully deleted!";
            header("Location: /transactions?message=" . urlencode($message));
            exit;
        }
    }
    public function createForm(): string|false
    {
        return View::make('createForm');
    }
    public function create(): void
    {
        $transactionModel = new Transaction();
        $transactionModel->insertTransactionToDB($_POST);
        http_response_code(301);
        $message = "Transaction successfully created!";
        header("Location: /transactions?message=" . urlencode($message));
        exit;
    }

    public function import(): void
    {
        try {
            header('Content-Description: File Transfer');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="transactions.csv"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');

            $file = fopen('php://output', 'w');
            $transactionModel = new Transaction();
            $transactions = $transactionModel->selectAll();

            fputcsv($file, ['Date       ', 'Check # ', 'Description    ', 'Amount'], enclosure: ' ');

            foreach ($transactions as $transaction) {
                $transaction['transaction_date'] = Formatter::formatDateForCSV($transaction['transaction_date']);
                $transaction['amount'] = Formatter::formatAmountForIndex((float)$transaction['amount']);
                fputcsv(
                    $file,
                    [$transaction['transaction_date'], $transaction['check_number'], $transaction['description'], $transaction['amount']],
                    enclosure: ' '
                );
            }
            exit;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function export(): string
    {
        try {
            foreach ($_FILES['exportfiles']['error'] as $error) {
                if ($error === UPLOAD_ERR_FORM_SIZE) {
                    return $this->index(['exportSizeError' => 'File size error']);
                }
            }
            foreach ($_FILES['exportfiles']['type'] as $type) {
                if ($type !== 'text/csv') {
                    return $this->index(['exportTypeError' => 'File type error']);
                }
            }
            $transactionModel = new Transaction();
            foreach ($_FILES['exportfiles']['tmp_name'] as $file) {
                $transactionModel->insertTransactionsFromCSVToDB($file);
            }
            return $this->index(['exportSuccess' => 'Files succesfully uploaded!<br/>']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
