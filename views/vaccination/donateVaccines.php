<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate vaccines</title>

    <link rel="stylesheet" type="text/css" href="/styles/all.css" />
    <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>


    <style>
        /* * {
            margin: 0;
            padding: 0;
        } */

        h1,
        label {
            color: black;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            background-color: rgb(0, 0, 0, 0.5);
            height: 100vh;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto;
            padding: 10px;
        }

        .grid-item {
            font-size: 15pt;
            text-align: center;
            padding: 1%;
            padding-bottom: 4%;
        }

        input,
        select {
            width: 80%;
            padding-left: 4%;
            padding-right: 1%;
        }

        label {
            float: left;
            padding-left: 15%;
        }

        .container {
            background-color: white;
            border-radius: 50px;
            width: 55%;
            padding: 2%;
            position: relative;
            top: 40%;
            transform: translateY(-50%);

        }

        button {
            width: 40%;
            position: relative;
            left: 30%;
            padding: 5%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Donate Vaccine</a>
        </div>
    </nav>
    <br><br>
    <div class="container">
        <form method="POST">

            <div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                    <h1>Donate Vaccine</h1>
                </div>
                <div class="col-4"></div>
            </div>
            <br>
            <div class="grid-container">
                <div class="grid-item"><label for="place">Place</label></div>
                <div class="grid-item"><input placeholder="Place" type="text" id="place" name="place" value="<?php echo $_GET['place']; ?>" required /></div>
                <div class="grid-item"> <label for="type">Type</label></div>
                <div class="grid-item"><select name="type" id="type" required>
                        <option value="Pfizer" <?php if (isset($_GET['type']) && $_GET['type'] === 'Pfizer') echo 'selected' ?>>Pfizer</option>
                        <option value="Aztraseneca" <?php if (isset($_GET['type']) && $_GET['type'] === 'Aztraseneca') echo 'selected' ?>>Aztraseneca</option>
                        <option value="Sinopharm" <?php if (isset($_GET['type']) && $_GET['type'] === 'Sinopharm') echo 'selected' ?>>Sinopharm</option>
                        <option value="Moderna" <?php if (isset($_GET['type']) && $_GET['type'] === 'Moderna') echo 'selected' ?>>Moderna</option>
                    </select></div>

                <div class="grid-item"><label for="dose">Dose</label></div>
                <div class="grid-item"> <input type="number" name="dose" id="dose" min=1 required></div>

                <div class="grid-item"> <label for="amount">Amount</label></div>
                <div class="grid-item"> <input type="number" id="amount" name="amount" value="<?php echo $_GET['amount']; ?>" placeholder="amount" min=0 required></div>

            </div>
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                    <button type="button" class="btn btn-success" onclick="donate()">Donate</button>

                </div>
                <div class="col-4"></div>
            </div>
    </div>
    </form>

    <script src="/scripts/common.js"></script>
    <script src="/scripts/vaccination/donateVaccines.js"></script>
</body>

</html>