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
    <title>Vaccine Availability</title>

    <style>
        body,
        html {
            background: url("/image/Covid-19-Test-and-Vaccine.jpg") no-repeat center;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: sans-serif;
            padding: 0;
            margin: 0;
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
            width: 60%;
        }

        label {
            float: left;
            padding-left: 45%;
        }

        button {
            width: 40%;
            position: relative;
            left: 30%;
            padding: 5%;
        }

        .cover {
            background-color: rgb(0, 0, 0, 0.8);
            width: 45%;
            margin: auto;
            border-radius: 10%;
            color: white;
            padding: 2%;
        }

        h1 {
            text-align: center;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <h2>Public works</h2>
    </nav>
    <br>
    <form>
        <div class="cover">
            <h1>Vacination Availability</h1>
            <div class="grid-container">

                <div class="grid-item"><label for="district">District:</label></div>
                <div class="grid-item">
                    <select name="district" id="district">
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
                </div>

                <div class="grid-item"><label for="type">Type:</label></div>
                <div class="grid-item">
                    <select name="type" id="type">
                        <option value="Pfizer">Pfizer</option>
                        <option value="Sinopharm">Sinopharm</option>
                        <option value="Aztraseneca">Aztraseneca</option>
                        <option value="Moderna">Moderna</option>
                    </select>
                </div>

                <div class="grid-item"><label for="dose">Dose:</label></div>
                <div class="grid-item"><input type="number" id="dose" name="dose" value="1" min="1" /></div>

                <div class="grid-item"><label for="date">Date:</label></div>
                <div class="grid-item"><input type="date" id="date" name="date" value="" /></div>

            </div>
            <button type="button" class="btn btn-success" onclick="getAvailability()">submit</button>
            <div class="item4">
                <table id="resultTable">
                </table>
            </div>

        </div>
    </form>

    <script type="text/javascript" src="/scripts/common.js"></script>
    <script type="text/javascript" src="/scripts/vaccineAvailability.js"></script>
</body>

</html>