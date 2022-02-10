<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <title>Testing Appointment</title>
    <style>
        #centers {
            text-align: left;
        }

        ul,
        ol {
            /* list-style-type: none; */
            padding-top: 2%;
            padding-bottom: 2%;
        }

        ul {
            margin-top: 2%;
            padding-left: 16%;
            padding-right: 20%;
        }

        li>input {
            float: right;
            text-align: right;
        }

        li>span {
            text-align: left;
            width: 300px;

        }



        body,
        html {
            margin: 0;
            padding: 0;
            background-color: #A9A9A9;
        }

        html {
            overflow-x: scroll;
            overflow-y: scroll;
        }

        .cover {
            background-color: rgb(0, 0, 0, 0.8);
            width: 60%;
            margin: auto;
            border-radius: 15px;
            color: white;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
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
            padding: 5%;
        }

        .grid-item {
            padding: 2%;
            font-size: 15pt;
            text-align: center;
            padding-left: 20%;
        }

        input,
        #districts {
            width: 60%;
            padding-left: 2%;
        }

        label {
            float: left;
            padding-left: 5%;
        }

        .cover button {
            width: 60%;
            position: relative;
            left: 20%;
        }

        #hide {
            display: none;
        }
/*
        input:hover,
        select:hover {
            border: 2px solid blue;
        }
*/
    </style>
</head>

<body>
    <?php
    @include('navbar.php') ?>
    <br>
    <div class="cover">
        <form>
            <h1>Testing Appointment</h1>
            <br>
            <div class="grid-container">
                <div class="grid-item"><label for="districts">Districts:</label></div>
                <div class="grid-item">
                    <select name="districts" id="districts">
                        <?php
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/global.php');
                        foreach (DISTRICTS as $type) {
                        ?>
                            <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                        <?php
                        } ?>
                    </select>
                    <br>
                </div>
                <div class="grid-item"><label for="date">Date:</label></div>
                <div class="grid-item"><input type="date" id="date" name="date"></div>


                <div class="grid-item"><label for="id">ID:</label></div>
                <div class="grid-item"><input type="text" id="id" name="id" size="12" placeholder="ID"></div>

            </div>
            <button type="button" class="btn btn-success" value="Submit" onclick="getCentres()">submit</button>
            <ul id="centers"></ul>
            <div id="hide">
                <div class="grid-container">

                    <div class="grid-item"><label for="name">Name:</label></div>
                    <div class="grid-item"><input type="text" id="name" name="name" placeholder="name"></div>

                    <div class="grid-item"><label for="email">Email:</label></div>
                    <div class="grid-item"><input type="email" id="email" name="email" placeholder="email"></div>

                    <div class="grid-item"><label for="contact">Contact:</label></div>
                    <div class="grid-item"><input type="tel" size="10" id="contact" name="contact" placeholder="0123456789"></div>
                </div>

                <button type="button" class="btn btn-success" onclick="submitRequest()">Submit</button>
            </div>
        </form>
        <br>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/views/modal.php');
    addModal('Place Appointment');
    ?>

    <script src="/scripts/common.js"></script>
    <script src="/scripts/testingAppointment.js"></script>
</body>

</html>