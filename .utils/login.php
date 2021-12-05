<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        header('HTTP/1.0 403 Forbidden');
        header('Location: ' . $_SERVER['REQUEST_URI']);
        die();
    }
    $authenticator = new AuthAccount();
    $authenticator->authenticate($_POST['username'], $_POST['password']);
} else if ($_SERVER['REQUEST_METHOD'] !== 'GET') { // unsupported method
    header('HTTP/1.0 403 Forbidden');
    header('Location: ' . $_SERVER['REQUEST_URI']);
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
} else { // GET
    session_start();
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <title>LOG IN PAGE</title>
        <link rel="stylesheet" type="text/css" href="/styles/all.css" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
        <!--link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet" /-->
        <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
        <style type="text/css">
            #loginButton {
                width: 250px;
            }

            #other {
                text-align: left;
                padding: 20px;
            }

            a:visited {
                color: red;
                background-color: transparent;
                text-decoration: none;
            }

            a:link {
                text-decoration: none;
            }

            a:hover {
                color: yellow;
                background-color: transparent;
                text-decoration: underline;
            }

            #invalid {
                width: 72%;
                height: 40px;
                position: relative;
                text-align: center;
                left: 13%;
            }

            #invalid p {
                background-color: rgb(255, 0, 0);
                border-radius: 10px;
                padding-top: 5px;
            }

            * {
                margin: 0;
                padding: 0;
            }

            .topic {
                max-width: 600px;
                min-width: 400px;
                width: auto;
                background-color: rgb(0, 0, 0);
                margin: 0 auto 10px auto;
                color: white;
                padding: 1% 0 1% 0;
                text-align: center;
                border-radius: 15px 15px 0px 0px;
            }

            #login {
                padding: 10px;
                height: auto;
            }

            body {
                background: url("/image/LoginImage.jpg") no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
                font-family: sans-serif;
            }

            #cover {
                max-width: 600px;
                min-width: 400px;
                background-color: rgb(0, 0, 0);
                width: 100%;
                border-bottom-left-radius: 15px;
                border-bottom-right-radius: 15px;
            }

            #UserName,
            #password {
                margin: 1%;
                position: relative;
                line-height: 40px;
                border-radius: 6px;
                padding: 0 2%;
                font-size: 16px;
                left: 10%;
                right: 10%;
                top: 20%;
                width: 70%;
            }

            #loginButton {
                width: 105%;
                display: inline-block;
                font-size: 20px;
                text-align: center;
                border-radius: 12px;
                border: 2px solid black;
                outline: none;
                cursor: pointer;
                transition: 0.25px;
            }

            i {
                color: white;
                font-size: 1.6rem;
            }

            .container {
                margin: 0 auto;
                position: relative;
                top: 150px;
                width: 400px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="topic">
                <h1>Admin Login</h1>
            </div>
            <div id="cover">
                <div id="invalid">
                    <?php
                    if (isset($_SESSION['invalidPass']) && $_SESSION['invalidPass']) {
                        echo "<p>Invalid login</p>";
                        $_SESSION['invalidPass'] = false;
                    }
                    session_write_close();
                    ?>
                </div>

                <form id="login" method='POST'>
                    <div class="form-group">
                        <i class="fas fa-users" aria-hidden="true"></i>
                        <input placeholder="Username" type="text" id="UserName" name="username" required />
                    </div>

                    <div class="form-group">
                        <i class="fas fa-user-lock"></i>
                        <input placeholder="Password" type="password" id="password" name="password" required />
                    </div>
            </div>

            <button id="loginButton" class="btn btn-primary" type="submit" id="btn">Log in</button>
            </form>
        </div>
    </body>

    </html>

<?php
}
?>