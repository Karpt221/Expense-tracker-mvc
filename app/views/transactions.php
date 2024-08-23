<?php

use app\core\Formatter;
use app\core\View;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th,
        table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th,
        tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }
    </style>
</head>

<body>
    <?php include 'operationsPanel.php'?>
    <a href="/transactions/create"><button>Create</button></a>
    <a href="/transactions/update"><button>Update</button></a>
    <a href="/transactions/delete"><button>Delete</button></a>
    <?php
    if(isset($message))echo "<div>{$message}</div>";
    ?>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Check #</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($transactions) && !empty($transactions)) {
                foreach ($transactions as $transaction) {
                    $color = Formatter::defineAmountColor($transaction["amount"]);
                    $transaction["transaction_date"] = Formatter::formatDateForIndex($transaction["transaction_date"]);
                    $transaction["amount"] = Formatter::formatAmountForIndex($transaction["amount"]);
                    echo <<<ROW
                                <tr>
                                    <td>{$transaction["transaction_date"]}</td>
                                    <td>{$transaction["check_number"]}</td>
                                    <td>{$transaction["description"]}</td>
                                    <td style="color:$color">{$transaction["amount"]}</td>
                                </tr>  
                                ROW;
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Income:</th>
                <td>
                    <?php
                    if (isset($totalValues)) {
                        echo Formatter::formatAmountForIndex($totalValues["totalIncome"]);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="3">Total Expense:</th>
                <td>
                    <?php
                    if (isset($totalValues)) {
                        echo Formatter::formatAmountForIndex($totalValues["totalExpense"]);
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="3">Net Total:</th>
                <td>
                    <?php
                    if (isset($totalValues)) {
                        echo Formatter::formatAmountForIndex($totalValues["netTotal"]);
                    }
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>