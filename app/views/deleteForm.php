<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete form</title>
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
    </style>
</head>

<body>
    <a href="/transactions"><button>Back</button></a>
    <form style="width: 60%; display: flex; flex-direction:column" action="/transactions/delete" method="post">
        <h2>Delete form</h2>
        <table>
            <thead>
                <tr>
                    <th></th>
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
                        echo <<<ROW
                                    <tr>
                                        <td> <input type="checkbox" name="transaction_ids[]" value="{$transaction['transaction_id']}" id="{$transaction['transaction_id']}"></td>
                                        <td>{$transaction["transaction_date"]}</td>
                                        <td>{$transaction["check_number"]}</td>
                                        <td>{$transaction["description"]}</td>
                                        <td>{$transaction["amount"]}</td>
                                    </tr>  
                            ROW;
                    }
                }
                ?>
            </tbody>
        </table>
        <input type='submit' value='Delete'>
    </form>
</body>

</html>