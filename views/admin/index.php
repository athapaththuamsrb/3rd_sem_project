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
            height: 100vh;
        }
    </style>
</head>
<div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

            </div>
        </nav>

        <div class="d-flex justify-content-center" id="title">
            Admin Dashboard
        </div>
        <div class="d-flex justify-content-center" id="actions">
            <a href="/admin/create_account.php"><button type="button" class="btn btn-primary" id="createAccountBtn">Create account</button></a>
        </div>


    </body>
</div>

</html>