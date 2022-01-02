<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate vaccines</title>
</head>

<body>
    <form method="POST">
        <label for="place">Place</label>
        <input placeholder="Place" type="text" id="place" name="place" value="<?php echo $_GET['place']; ?>" required />
        <label for="type">Type</label>
        <select name="type" id="type" required>
            <option value="Pfizer" <?php if (isset($_GET['type']) && $_GET['type'] === 'Pfizer') echo 'selected' ?>>Pfizer</option>
            <option value="Aztraseneca" <?php if (isset($_GET['type']) && $_GET['type'] === 'Aztraseneca') echo 'selected' ?>>Aztraseneca</option>
            <option value="Sinopharm" <?php if (isset($_GET['type']) && $_GET['type'] === 'Sinopharm') echo 'selected' ?>>Sinopharm</option>
            <option value="Moderna" <?php if (isset($_GET['type']) && $_GET['type'] === 'Moderna') echo 'selected' ?>>Moderna</option>
        </select>

        <label for="dose">Dose</label>
        <input type="number" name="dose" id="dose" min=1 required>

        <label for="amount">Amount</label>
        <input type="number" id="amount" name="amount" value="<?php echo $_GET['amount']; ?>" placeholder="amount" min=0 required>

        <button type="button" onclick="donate()">Donate</button>
    </form>

    <script src="/scripts/common.js"></script>
    <script src="/scripts/vaccination/donateVaccines.js"></script>
</body>

</html>