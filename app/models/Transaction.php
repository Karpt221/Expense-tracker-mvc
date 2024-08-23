<?php

declare(strict_types=1);

namespace app\models;

use app\core\Formatter;
use app\core\Model;

class Transaction extends Model
{
    public function selectAll(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM transactions');

        $stmt->execute();

        $transactions = $stmt->fetchAll();

        return $transactions ? $transactions : [];
    }

    public function getTotalValues(array $transactions): array
    {
        $totalValues = [
            "totalIncome" => 0,
            "totalExpense" => 0,
            "netTotal" => 0
        ];
        foreach ($transactions as $transaction) {
            if ($transaction["amount"] > 0) {
                $totalValues["totalIncome"] += $transaction["amount"];
            } elseif ($transaction["amount"] < 0) {
                $totalValues["totalExpense"] += $transaction["amount"];
            }
        }
        $totalValues["netTotal"] = $totalValues["totalIncome"]
            + $totalValues["totalExpense"];
        return $totalValues;
    }

    public function insertTransactionToDB(array $transaction)
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO transactions
            (transaction_date, check_number, description, amount) 
            VALUES (?, ?, ?, ?);');

            $transaction['transaction_date'] = Formatter::formatDateForDB($transaction['transaction_date']);
            $transaction['amount'] = Formatter::formatAmountForDB($transaction['amount']);
            if (ctype_space($transaction['check_number']) || $transaction['check_number'] === '') {
                $transaction['check_number'] = null;
            }
            $stmt->execute([
                $transaction['transaction_date'],
                $transaction['check_number'],
                $transaction['description'],
                $transaction['amount']
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function insertTransactionsFromCSVToDB(string $fileName)
    {
        try {
            $file = fopen($fileName, "r");
            fgetcsv($file);
            while (($transaction = fgetcsv($file)) !== false) {
                $transactionData = [
                    'transaction_date' => $transaction[0],
                    'check_number' => $transaction[1],
                    'description' => $transaction[2],
                    'amount' => $transaction[3]
                ];
                $this->insertTransactionToDB($transactionData);
            }
            fclose($file);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteTransactionsFromDB(array $transaction_ids)
    {
        try {
            $stmt = $this->db->prepare('DELETE FROM transactions WHERE transaction_id = ?');
            foreach ($transaction_ids as $id) {
                $stmt->execute([$id]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateTransactionsInDB($transactinos)
    {
        try {
            $stmt = $this->db->prepare('UPDATE transactions 
            SET transaction_date=?, check_number=?, description=?, amount=?
            WHERE transaction_id=?');
            for ($i=0, $len = count($transactinos['ids']); $i < $len; $i++) { 
                $stmt->execute([
                    $transactinos['transaction_date'][$i],
                    $transactinos['check_number'][$i],
                    $transactinos['description'][$i],
                    $transactinos['amount'][$i],
                    $transactinos['ids'][$i]
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
