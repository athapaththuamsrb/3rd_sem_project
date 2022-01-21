<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <!--link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet" /-->
    <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <title>Testing Availability</title>

    <style>
        body,
        html {
            padding: 0;
            margin: 0;
            background-color: #A9A9A9;
        }

        table {
            background-color: black;
            color: white;
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }


        .item4 {
            /* height: 300px; */
            width: 300px;
            margin: auto;
            margin-top: 60px;

        }

        h2 {
            color: white;
            padding-left: 0.5%;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto;
            padding: 1%;
        }

        .grid-item {
            font-size: 15pt;
            text-align: center;
            padding-right: 5%;
            padding-bottom: 5%;
        }

        input,
        select {
            width: 70%;
            padding-left: 5%;
            border-radius: 5px;
        }

        label {
            float: left;
            padding-left: 45%;
        }

        .cover button {
            width: 40%;
            position: relative;
            left: 30%;
        }

        .cover {
            background-color: rgb(0, 0, 0, 0.8);
            width: 45%;
            margin: auto;
            border-radius: 15px;
            color: white;
            padding: 2%;
        }

        .cover h1 {
            text-align: center;
        }

        nav a {
            margin-right: 1%;
        }

        #resultDiv {
            width: 90%;
        }

        td {
            text-align: center;
        }

        input:hover,
        select:hover {
            border: 2px solid blue;
        }
    </style>

</head>

<body>
    <?php
    @include('navbar.php') ?>
    <br>
    <form>
        <div class="cover">
            <h1>Testing Availability</h1>
            <div class="grid-container">

                <div class="grid-item"><label for="district">District:</label></div>
                <div class="grid-item">
                    <select name="district" id="district">
                        <?php
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/global.php');
                        foreach (DISTRICTS as $type) {
                        ?>
                            <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                        <?php
                        } ?>
                    </select>
                </div>

                <div class="grid-item"><label for="type">Type:</label></div>
                <div class="grid-item">
                    <select name="type" id="type">
                        <?php
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/global.php');
                        foreach (TESTS as $type) {
                        ?>
                            <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                        <?php
                        } ?>
                    </select>
                </div>

                <div class="grid-item"><label for="date">Date:</label></div>
                <div class="grid-item"><input type="date" id="date" name="date" value="" min="@DateTime.Now.ToString('yyyy-MM-ddThh:mm')" /></div>

            </div>
            <button type="button" class="btn btn-success" onclick="getAvailability()">submit</button>
            <div id="resultDiv" class="item4"></div>

        </div>
    </form>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/views/modal.php');
    addModal('Testing Availability');
    ?>
    <script src="/scripts/common.js"></script>
    <script src="/scripts/testingAvailability.js"></script>
</body>

</html>