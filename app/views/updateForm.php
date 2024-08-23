<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update form</title>
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
    <form style="width: 60%; display: flex; flex-direction:column" action="/transactions/update" method="post">
        <h2>Update form</h2>
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
                                        <td><button type='button' class="edit-btn">Edit</button>
                                        <input class="input id" type='hidden' value='{$transaction["transaction_id"]}'></td>
                                        <td class="input date">{$transaction["transaction_date"]}</td>
                                        <td class="input checknum">{$transaction["check_number"]}</td>
                                        <td class="input description">{$transaction["description"]}</td>
                                        <td class="input amount">{$transaction["amount"]}</td>
                                    </tr>  
                            ROW;
                    }
                }
                ?>
            </tbody>
        </table>
        <input type='submit' value='Update'>
    </form>
    <script >
       document
    .querySelectorAll('.edit-btn')
    .forEach(btn => {
        btn.addEventListener('click', () => {
            const parentRow = btn.closest('tr');
            btn.disabled = true;

            parentRow.querySelectorAll('.input')
                .forEach(input => {
                    if (input.classList.contains('date')) {
                        const date = input.innerText;
                        input.innerHTML = `<input required type='date' name='transaction_date[]'  value="${date}">`;
                    }else
                    if (input.classList.contains('checknum')) {
                        const checkNum = input.innerText;
                        input.innerHTML = `<input min="1" type="number" name="check_number[]"  value="${checkNum}" >`;
                    }else
                    if (input.classList.contains('description')) {
                        const description = input.innerText;
                        input.innerHTML = `<input maxlength="100" required type="text" name="description[]"  value="${description}">`;
                    }else
                    if (input.classList.contains('amount')) {
                        const amount = input.innerText;
                        input.innerHTML = `<input required step="0.01" type="number" name="amount[]"  value="${amount}">`;
                    }
                    else
                    if (input.classList.contains('id')) {
                        input.setAttribute('name','ids[]');
                    }
                });
        });
    });
    </script>
</body>

</html>