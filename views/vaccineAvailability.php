<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccine Availability</title>

    <style>
        table {
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

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .item4 {
            /* height: 300px; */
            width: 300px;
            margin: auto;
            margin-top: 60px;

        }
    </style>

</head>

<body>
    <form>
        <label for="district">District:</label>
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
        </select><br>
        <label for="type">Type:</label>
        <select name="type" id="type">
            <option value="Pfizer">Pfizer</option>
            <option value="Sinopharm">Sinopharm</option>
            <option value="Aztraseneca">Aztraseneca</option>
            <option value="Moderna">Moderna</option>
        </select>
        <label for="dose">Dose:</label>
        <input type="number" id="dose" name="dose" value="1" min="1" /><br />
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="" />

        <input type="button" value="Submit" onclick="getAvailability()">

        <div class="item4">
            <table id="resultTable">
            </table>
        </div>
    </form>

    <script type="text/javascript" src="/scripts/common.js"></script>
    <script type="text/javascript" src="/scripts/vaccineAvailability.js"></script>
</body>

</html>