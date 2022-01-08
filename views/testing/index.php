<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="/styles/all.css" />
    <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: url("/image/vaccineDash.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            background-color: rgb(190, 190, 190);
        }

        #actions {
            margin-top: 100px;
        }

        #createAccountBtn {
            padding: 20px 30px;
            font-size: 25px;
            font-weight: 500;
        }

        #title {
            margin-top: 30px;
            font-size: 50px;
            font-weight: 600;
            color: white;
        }

        .mask {
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .btn-shape {
            width: 250px;
            font-size: 150%;
        }
    </style>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Testing Center</a>
            <a href="/index.php?logout=1"><button type="button" class="btn btn-primary">Logout</button></a>

        </div>
    </nav>

    <div class="d-flex justify-content-center" id="title">
        Testing Center Dashboard
    </div>
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-5" id="actions">
                <a href="/testing/addRecord.php"><button type="button" class="btn btn-primary btn-shape">Add Record</button></a>
            </div>
            <div class="col-1"></div>
            <div class="col-5" id="actions">
                <a href="/testing/addStock.php"><button type="button" class="btn btn-primary btn-shape">Add Stock</button></a>
            </div>
        </div>

</body>

</html>