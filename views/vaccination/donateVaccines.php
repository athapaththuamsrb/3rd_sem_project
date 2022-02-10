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
        h1,
        label {
            color: white;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            background-color: #A9A9A9;
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
            background-color: rgb(0, 0, 0, 0.8);
            color: white;
            border-radius: 50px;
            width: 55%;
            padding: 2%;
            position: relative;
            top: 40%;
            transform: translateY(-50%);
            border: 2px black solid;

        }

        .container button {
            width: 40%;
            position: relative;
            left: 30%;
            padding: 5%;
        }
/*
        input:hover,
        select:hover {
            border: 2px solid blue;
        }
*/
        button:hover {
            -ms-transform: scale(1.2);
            /* IE 9 */
            -webkit-transform: scale(1.2);
            /* Safari 3-8 */
            transform: scale(1.2);
        }
    </style>
</head>

<body>
    <?php
    @include('navbar.php') ?>
    <br>
    <div class="container">
        <form method="POST">

            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <h1>Donate Vaccine</h1>
                </div>
                <div class="col-3"></div>
            </div>
            <br>
            <div class="grid-container">
                <div class="grid-item"><label for="place">Place</label></div>
                <div class="grid-item"><input placeholder="Place" type="text" id="place" name="place" value="<?php echo $_GET['place']; ?>" required /></div>
                <div class="grid-item"> <label for="type">Type</label></div>
                <div class="grid-item">
                    <select name="type" id="type" required>
                        <?php
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/global.php');
                        foreach (VACCINES as $type) {
                        ?>
                            <option value="<?php echo $type; ?>" <?php if (isset($_GET['type']) && $_GET['type'] === $type) echo 'selected' ?>><?php echo $type; ?></option>
                        <?php
                        } ?>
                    </select>
                </div>

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
        </form>
    </div>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/views/modal.php');
    addModal('Donate Vaccines');
    ?>

    <script src="/scripts/common.js"></script>
    <script src="/scripts/vaccination/donateVaccines.js"></script>
</body>

</html>