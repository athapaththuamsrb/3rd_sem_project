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
        margin-top: 10px;
        background: url("/image/Covid-19-Test-and-Vaccine.jpg") no-repeat center;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        font-family: sans-serif;
    }

    .cover {
        background-color: rgb(0, 0, 0, 0.8);
        width: 50%;
        margin: auto;
        border-radius: 10%;
        color: white;
    }

    .feild,
    button {
        padding: 2%;
        margin: 2%;
    }

    h1 {
        text-align: center;
    }
</style>

<body>
    <div class="cover">
        <h1>Vacination Certificate</h1>
        <div class="feild">
            <label for="inputID" class="form-label txt">Enter ID</label>
            <input type="text" class="form-control" id="inputID">
        </div>
        <br>
        <div class="feild">
            <label for="inputToken" class="form-label txt">Enter Token</label>
            <input type="text" class="form-control" id="inputToken">
        </div>
        <br>
        <center><button type="button" class="btn btn-primary" onclick="getCert()">Download</button></center>
    </div>
    <script type="text/javascript" src="/scripts/common.js"></script>
    <script type="text/javascript" src="/scripts/vaccinationCertificate.js"></script>
</body>

</html>