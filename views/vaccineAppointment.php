<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <title>Vaccine Appoinment</title>
    <style>
        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }

        /* Add Animation */
        @-webkit-keyframes animatetop {
            from {
                top: -300px;
                opacity: 0
            }

            to {
                top: 0;
                opacity: 1
            }
        }

        @keyframes animatetop {
            from {
                top: -300px;
                opacity: 0
            }

            to {
                top: 0;
                opacity: 1
            }
        }

        /* The Close Button */
        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        #centers {
            text-align: center;
        }

        ul,
        ol {
            list-style-type: none;
        }

        body,
        html {
            background: url("/image/Covid-19-Test-and-Vaccine.jpg") no-repeat center;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        html {
            overflow-x: scroll;
            overflow-y: scroll;
        }

        .cover {
            background-color: rgb(0, 0, 0, 0.8);
            width: 60%;
            margin: auto;
            border-radius: 10%;
            color: white;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
            font-size: large;
        }

        .modal-body {
            padding: 2px 16px;
            font-size: 20px;
        }

        .modal-footer {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
            font-size: large;
        }

        h1 {
            text-align: center;
            padding: 5%;
        }

        h2 {
            color: white;
            padding: 0.5%;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto;
            padding: 10pt;
        }

        .grid-item {
            padding: 2%;
            font-size: 15pt;
            text-align: center;
        }

        input,
        #districts {
            width: 60%;
        }

        label {
            float: left;
        }

        button {
            width: 60%;
            position: relative;
            left: 20%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <h2>Public works</h2>
    </nav>
    <br>
    <div class="cover">
        <form>
            <h1>Vaccine Appointment</h1>
            <br>
            <div class="grid-container">
                <div class="grid-item"><label for="districts">Districts:</label></div>
                <div class="grid-item">
                    <select name="districts" id="districts">
                        <option value="Colombo">Colombo</option>
                        <option value="Kalutara">Kalutara</option>
                        <option value="Gampaha">Gampaha</option>
                        <option value="Puttalam">Puttalam</option>
                        <option value="Kurunegala">Kurunegala</option>
                        <option value="Anuradhapura">Anuradhapura</option>
                        <option value="Polonnaruwa">Polonnaruwa</option>
                        <option value="Matale">Matale</option>
                        <option value="Nuwara Eliya">Nuwara Eliya</option>
                        <option value="Kegalle">Kegalle</option>
                        <option value="Ratnapura">Ratnapura</option>
                        <option value="Trincomalee">Trincomalee</option>
                        <option value="Batticaloa">Batticaloa</option>
                        <option value="Ampara">Ampara</option>
                        <option value="Badulla">Badulla</option>
                        <option value="Monaragala">Monaragala</option>
                        <option value="Hambantota">Hambantota</option>
                        <option value="Matara">Matara</option>
                        <option value="Galle">Galle</option>
                        <option value="Jaffna">Jaffna</option>
                        <option value="Kilinochchi">Kilinochchi</option>
                        <option value="Mannar">Mannar</option>
                        <option value="Mullaitivu">Mullaitivu</option>
                        <option value="Vavuniya">Vavuniya</option>
                        <option value="Kandy">Kandy</option>
                    </select>
                    <br>
                </div>
                <div class="grid-item"><label for="date">Date:</label></div>
                <div class="grid-item"><input type="date" id="date" name="date"></div>


                <div class="grid-item"><label for="id">ID:</label></div>
                <div class="grid-item"><input type="text" id="id" name="id"></div>

            </div>
            <button class="btn btn-success" value="Submit" onclick="getCentres()">submit</button>
            <br>

            <ul id="centers"></ul>

            <div class="grid-container">

                <div class="grid-item"><label for="name">Name:</label></div>
                <div class="grid-item"><input type="text" id="name" name="name"></div>

                <div class="grid-item"><label for="email">Email:</label></div>
                <div class="grid-item"><input type="text" id="email" name="email"></div>



                <div class="grid-item"><label for="contact">Contact:</label></div>
                <div class="grid-item"><input type="text" id="contact" name="contact"></div>
            </div>

            <button class="btn btn-success" onclick="submitRequest()">Submit</button>
        </form>
        <br>
    </div>
    <!-- Trigger/Open The Modal -->
    <!-- <button id="myBtn">Open Modal</button> -->
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header" id="mHeader">
                <span class="close">&times;</span>
                <h2>Vaccine Appointment</h2>
            </div>
            <div class="modal-body" id="mBody">
                <p>Appointment Success!</p>
            </div>
            <div class="modal-footer" id="mFooter">
                <h3>Thank you!</h3>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="/scripts/common.js"></script>
    <script type="text/javascript" src="/scripts/vaccineAppointment.js"></script>
</body>

</html>