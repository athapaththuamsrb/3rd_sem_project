<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/styles/all.css" />
    <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <title>Update Stock</title>
</head>
<style>
    html,
    body {
        padding: 0;
        margin: 0;
    }

    .centerBox {
        text-align: center;
        position: absolute;
        top: 30%;
        left: 25%;
        width: 50%;
        background-color: antiquewhite;
        border: 2px solid black;
        border-radius: 15px;
    }

    .centerBox:hover {
        border: 4px solid black;
    }

    input:hover,
    select:hover {
        border: 2px solid blue;
    }

    .centerBox button {
        background-color: green;
        color: white;
        border: 2px solid black;
        border-radius: 15px;
        width: 40%;
        margin: 10px;
    }

    button:hover {
        -ms-transform: scale(1.2);
        /* IE 9 */
        -webkit-transform: scale(1.2);
        /* Safari 3-8 */
        transform: scale(1.2);
    }

    nav {
        background-color: rgb(2, 2, 59);
        height: 10vh;
        width: 100%;
        padding: 0;
        margin: 0;
    }

    #type {
        width: 30%;
        font-size: medium;
    }

    #type,
    input {
        width: 90%;
        font-size: 15pt;
        padding-left: 4%;
    }

    .grid-container {
        display: grid;
        grid-template-columns: auto auto auto;
        padding: 10px;
    }

    .grid-item {
        padding-left: 50%;
        padding-bottom: 5%;
        font-size: 15pt;
        text-align: center;
    }

    label {
        text-align: left;
        float: left;
    }

    /* .dashboard {
        float: right;
    } */

    nav a {
        margin-right: 1%;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Vaccination Center</a>
            <a class="nav-link" href="/vaccination/index.php"><button type="button" class="btn btn-primary dashboard">Dashboard</button></a>

        </div>

    </nav>
    <fieldset class="centerBox">
        <legend>Update the stock</legend>
        <div class="grid-container">
            <div class="grid-item">
                <label for="type">type:</label>&nbsp;
            </div>
            <div class="grid-item">
                <select name="type" id="type" readonly="readonly">
                    <option value="Pfizer" <?php if (isset($_GET['type']) && $_GET['type'] === 'Pfizer') echo 'selected' ?>>Pfizer</option>
                    <option value="Aztraseneca" <?php if (isset($_GET['type']) && $_GET['type'] === 'Aztraseneca') echo 'selected' ?>>Aztraseneca</option>
                    <option value="Sinopharm" <?php if (isset($_GET['type']) && $_GET['type'] === 'Sinopharm') echo 'selected' ?>>Sinopharm</option>
                    <option value="Moderna" <?php if (isset($_GET['type']) && $_GET['type'] === 'Moderna') echo 'selected' ?>>Moderna</option>
                </select>
            </div>
            <br>
            <div class="grid-item"><label for="amount">Dose:</label>&nbsp;</div>
            <div class="grid-item"><input type="number" id="dose" name="dose" placeholder="Dose" min=1></div>
            <br>
            <div class="grid-item"><label for="amount">amount:</label>&nbsp;</div>
            <div class="grid-item"><input type="number" id="amount" name="amount" placeholder="Amount" value="<?php if (isset($_GET['amount'])) echo $_GET['amount'] ?>" min=0></div>
            <br>
        </div>

        <button type="button" class="btn btn-success" onclick="updateStock()">Update</button>
    </fieldset>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/views/modal.php');
    addModal('Update Stock');
    ?>

    <script src="/scripts/common.js"></script>
    <script src="/scripts/modal.js"></script>
    <script src="/scripts/vaccination/updateStock.js"></script>
</body>

</html>