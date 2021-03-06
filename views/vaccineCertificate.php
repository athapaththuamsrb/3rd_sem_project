<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/styles/all.css" />
    <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <title>Vaccine Certificate</title>
</head>
<style>
    body,
    html {
        padding: 0;
        margin: 0;
        background-color: #A9A9A9;
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

    input {
        width: 60%;
        padding-left: 5%;
    }

    label {
        float: left;
        padding-left: 5%;
    }

    .cover button {
        width: 40%;
        position: relative;
        left: 30%;
    }

    nav a {
        margin-right: 1%;
    }
/*
    input:hover,
    select:hover {
        border: 2px solid blue;
    }
*/
</style>

<body>
    <?php
    @include('navbar.php') ?>
    <br>
    <div class="cover">
        <h1>Vaccination Certificate</h1>
        <div class="grid-container">
            <div class="grid-item"><label for="inputID" class="form-label txt">Enter ID:</label></div>
            <div class="grid-item"><input type="text" class="form-control" id="inputID" onkeypress="keypress(event, 0);" size="12"></div>

            <div class="grid-item"><label for="inputToken" class="form-label txt">Enter Token:</label></div>
            <div class="grid-item"><input type="text" class="form-control" id="inputToken" onkeypress="keypress(event, 1);" size="6"></div>
            <br>
        </div>
        <button id="submitBtn" class="btn btn-success" onclick="getCert()">Download</button>
        <br>
    </div>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/views/modal.php');
    addModal('Vaccine Certificate');
    ?>
    <script src="/scripts/common.js"></script>
    <script src="/scripts/vaccinationCertificate.js"></script>
</body>

</html>