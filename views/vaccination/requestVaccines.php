<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Vaccines</title>
</head>

<body>
    <form method="POST">
        <label for="type">
            <h2 class="field">Vaccine Type</h2>
        </label>
        <input type="text" name="type" id="type">
        <label for="dose">
            <h2 class="field">Dose</h2>
        </label>
        <input type="number" name="dose" id="dose">
        <label for="amount">
            <h2 class="field">Amount</h2>
        </label>
        <input type="number" name="amount" id="amount">
        <input type="submit" value="Request">
    </form>
</body>

</html>