<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/styles/modal.css" />
    <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <title>Vaccine Appointment</title>
    <style>
        #centers {
            text-align: center;
        }

        ul,
        ol {
            list-style-type: none;
            padding-top: 2%;
            padding-bottom: 2%;
        }

        ul {
            margin-top: 2%;
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


        h1 {
            text-align: center;
            padding: 2%;
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

        button {
            width: 60%;
            position: relative;
            left: 20%;
        }

        #hide {
            display: none;
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
                <div class="grid-item"><input type="text" id="id" name="id" size="12" placeholder="id"></div>

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
    <!-- Trigger/Open The Modal -->
    <!-- <button id="myBtn">Open Modal</button> -->
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header" id="mHeader">
                <span class="close" id="close-span">&times;</span>
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

    <script src="/scripts/common.js"></script>
    <script src="/scripts/modal.js"></script>
    <script src="/scripts/vaccineAppointment.js"></script>
</body>

</html>