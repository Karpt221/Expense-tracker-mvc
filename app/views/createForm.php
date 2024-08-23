<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="/transactions"><button>Back</button></a>
    <form style="width: 30%; display: flex; flex-direction:column" action="/transactions/create" method="post">
        <h2>Create form</h2>
        <label for="transaction_date">Date</label>
        <input required type="date" name="transaction_date" id="transaction_date">
        <label for="check_number">Check#</label>
        <input min="1" type="number" name="check_number" id="check_number">
        <label for="description">Description</label>
        <input maxlength="100" required type="text" name="description" id="description">
        <label for="amount">Amount</label>
        <input required step="0.01" type="number" name="amount" id="amount">
        <input type="submit" value="Create">
    </form>
</body>

</html>