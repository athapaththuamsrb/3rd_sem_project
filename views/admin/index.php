<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="/styles/all.css" />
    <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: url("/image/ad1.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-color: rgb(190, 190, 190);
        }

        #actions {
            margin-top: 100px;
        }

        #createAccountBtn {
            padding: 20px 30px;
            font-size: 20pt;
            font-weight: 500;
        }

        #title {
            margin-top: 30px;
            font-size: 42pt;
            font-weight: 600;
            color: black;
        }

        .btn:hover {
            -ms-transform: scale(1.2);
            /* IE 9 */
            -webkit-transform: scale(1.2);
            /* Safari 3-8 */
            transform: scale(1.2);
            background-color: blue;
        }

        body {
            height: auto;
            background-color: rgba(0, 0, 0, 0.6);
        }

        nav {
            padding: 5px 0px 5px 0px;
            height: 80px;
            width: 100%;
        }

        .container-fluid {
            padding-left: 1.5%;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <h1 class="navbar-brand"><img src="/image/icon-public.gif" height="48px">&nbsp;Administrator</h1>
            <a href="/index.php?logout=1"><button type="button" class="btn btn-primary">Logout</button></a>
        </div>
    </nav>
    <!-- <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);"> -->

    <div class="d-flex justify-content-center" id="title">
        Admin Dashboard
    </div>
    <div class="d-flex justify-content-center" id="actions">
        <a href="/admin/createAccount.php"><button type="button" class="btn btn-primary" id="createAccountBtn">Create account</button></a>
    </div>
    <!-- </div> -->
</body>

</html>