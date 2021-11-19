<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_SESSION['user'];
    if (isset($_POST['date']) && isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['amount']) && isset($_POST['onlineAmount']) && $_POST['date'] && $_POST['type'] && is_numeric($_POST['dose']) && is_numeric($_POST['amount']) && is_numeric($_POST['onlineAmount'])) {
        $user = $_SESSION['user'];
        $district = $user->getDistrict();
        $place = $user->getPlace();
        $date = new DateTime($_POST['date']);
        $type = $_POST['type'];
        $dose = intval($_POST['dose']);
        $amount = intval($_POST['amount']);
        $online = intval($_POST['onlineAmount']);
        require_once('../.utils/dbcon.php');
        $con = DatabaseConn::get_conn();
        if ($con->add_stock($district, $place, $date, $type, $dose, $amount - $online, $online)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccine Centre Admin Dashboard</title>

    <link rel="stylesheet" type="text/css" href="/styles/all.css" />
    <link rel="stylesheet" href="/css/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <script src="/css/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>

    <style>
        .item4 {
            /* height: 300px; */
            width: 300px;
            margin: auto;
            margin-top: 60px;

        }

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
    </style>
</head>

<body>
    <form>
        <div class="container">
            <div class="row">
                <div class="col">
                    <label for="date">Date:</label><br>
                    <input type="date" id="date" name="date" value=""><br>
                </div>
                <div class="col">
                    <label for="type">Vaccine Type:</label><br>
                    <input type="text" id="type" name="type" value=""><br>
                </div>
                <div class="col">
                    <label for="dose">Dose:</label><br>
                    <input type="number" id="dose" name="dose" value=""><br>
                </div>
                <div class="col">
                    <label for="amount">Amount:</label><br>
                    <input type="number" id="amount" name="amount" value=""><br>
                </div>
                <div class="col">
                    <label for="onlineAmount">Online Booking Amount:</label><br>
                    <input type="number" id="onlineAmount" name="onlineAmount" value=""><br>
                </div>
                <div class="col">
                    <input type="button" value="Submit" onclick="submit1()">
                </div>
            </div>
        </div>

        <!-- <form>
            <label for="date">Date:</label><br>
            <input type="text" id="date" name="date" value=""><br>


            <input type="button" value="Submit" onclick="submit2()">

        </form> -->

        <div class="item4">
            <table id="resultTable">
            </table>
        </div>






    </form>

    <script type="text/javascript">
        function submit1() {
            let date = document.getElementById("date").value;
            let type = document.getElementById("type").value;
            let dose = document.getElementById("dose").value;
            let amount = document.getElementById("amount").value;
            let onlineAmount = document.getElementById("onlineAmount").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", document.URL, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            let senddata = `date=${encodeURIComponent(date)}&type=${encodeURIComponent(type)}&dose=${dose}&amount=${amount}&onlineAmount=${onlineAmount}`;
            console.log(senddata);
            xhr.send(senddata);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    let data = JSON.parse(xhr.responseText);
                    console.log(data);
                    alert(data);
                }
            }
        }

        function submit2() {


            var data = [{
                    type: 'Pfizer',
                    date: '02/11/2021',
                    amount: 700,
                    online: 600
                },
                {
                    type: 'Astrsasenica',
                    date: '03/11/2021',
                    amount: 1000,
                    online: 800
                },
                {
                    type: 'Pfizer',
                    date: '10/11/2021',
                    amount: 500,
                    online: 400
                },
                {
                    type: 'Astrsasenica',
                    date: '30/11/2021',
                    amount: 900,
                    online: 700
                }
            ]
            let output = document.getElementById("resultTable");
            var tableContent = "<tr><th>Type</th><th>Amount</th><th>Online Amount</th><th>Submit</th></tr>"
            for (index = 0; index < data.length; index++) {
                tableContent += "<tr><form><td>" + '<input type="text" id="date" name="date" value=' + data[index]["type"] + '>' + "</td>" +
                    "<td>" + '<input type="text" id="date" name="date" value=' + data[index]["amount"] + '>' + "</td>" +
                    "<td>" + '<input type="text" id="date" name="date" value=' + data[index]["online"] + '>' + "</td>" +
                    "<td>" + '<input type="button" value="Submit" onclick="submit()"' + '>' + "</td></form>" +
                    "</tr>";
            }
            output.innerHTML = tableContent;

        }
    </script>

</body>
<form>


</form>

</html>