<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['district']) && isset($_POST['date']) && isset($_POST['id']) && $_POST['district'] && $_POST['date'] && $_POST['id']) {
        $district = $_POST['district'];
        $date = new DateTime($_POST['date']);
        $id = $_POST['id'];
        require_once('.utils/dbcon.php');
        if (isset($_POST['vaccineCenter']) && isset($_POST['vaccineType']) && $_POST['vaccineCenter'] && $_POST['vaccineType']) {
            if ($con = DatabaseConn::get_conn()) {
                $place = $_POST['vaccineCenter'];
                $type = $_POST['vaccineType'];
                $name = isset($_POST['name']) ? $_POST['name'] : '';
                $email = isset($_POST['email']) ? $_POST['email'] : '';
                $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
                $details = ['id' => $id, 'name' => $name, 'contact' => $contact, 'email' => $email, 'district' => $district, 'place' => $place, 'date' => $date, 'type' => $type];
                if ($con->add_appointment($details)) {
                    $data = ['status' => true];
                } else {
                    $data = ['status' => false];
                }
            } else {
                $data = ['status' => false];
            }
        } else {
            if ($con = DatabaseConn::get_conn()) {
                $data = $con->filter_vaccine_centers($district, $date, $id);
            } else {
                $data = [];
            }
            //$data = [['place' => 'General Hosp. Kalutara', 'Pfizer' => 50, 'Sinopharm' => 20], ['place' => 'Base Hosp. Horana', 'Aztraseneca' => 40, 'Sinopharm' => 100, 'Moderna' => 30], ['place' => 'MOH Gampaha', 'Pfizer' => 50, 'Moderna' => 50]];
        }
        echo json_encode($data);
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
    </style>
</head>

<body>
    <form>
        <label for="districts">Districts:</label>
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
        </select><br>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date">

        <label for="id">ID:</label>
        <input type="text" id="id" name="id">

        <input type="button" value="Submit" onclick="submit1()">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name">

        <label for="email">Email:</label>
        <input type="text" id="email" name="email">

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact">
    </form>
    <ul id="centers">

    </ul>
    <input type="button" value="select" onclick="submit2()">

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
    <script type="text/javascript">
        function submit1() {
            let district = document.getElementById("districts").value;
            let date = document.getElementById("date").value;
            let id = document.getElementById("id").value;
            let output = document.getElementById("centers");
            var xhr = new XMLHttpRequest();
            xhr.open("POST", document.URL, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("district=" + encodeURIComponent(district) + '&date=' + encodeURIComponent(date) + '&id=' + encodeURIComponent(id));
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    let data = JSON.parse(xhr.responseText);
                    var content = "";
                    var possibleVaccines = ["Pfizer", "Sinopharm", "Aztraseneca", "Moderna"];
                    data.forEach(centre => {
                        content += "<li>" + centre["place"] + "<ol>";
                        for (i = 0; i < possibleVaccines.length; i++) {
                            if (centre[possibleVaccines[i]] != undefined) {
                                let vaccine_name = possibleVaccines[i];
                                let availability = centre[possibleVaccines[i]]['appointments'];
                                var text = centre["place"] + "?" + [vaccine_name];
                                var editText = text.replace(/ /g, "@");
                                content += "<li>" + [vaccine_name] + ":" + availability +
                                    '<input type = "radio"  name ="appoinment" value =' + editText + ' /> ' + '</li>';
                            }
                        }
                        content += "</ol></li>"
                    });
                    output.innerHTML = content;
                }
            }
        }

        function submit2() {
            let elem = document.querySelector('input[name="appoinment"]:checked');
            if (!elem) return;
            var text = elem.value.replace(/@/g, " ").split("?");
            let district = document.getElementById("districts").value;
            let date = document.getElementById("date").value;
            let id = document.getElementById("id").value;
            let name = document.getElementById("name").value;
            let email = document.getElementById("email").value;
            let contact = document.getElementById("contact").value;

            let vaccineCenter = text[0]
            let vaccineType = text[1]

            var xhr = new XMLHttpRequest();
            xhr.open("POST", document.URL, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            let msg = 'district=' + encodeURIComponent(district) + '&date=' + encodeURIComponent(date) + '&id=' + encodeURIComponent(id) + '&name=' + encodeURIComponent(name) + '&email=' + encodeURIComponent(email) + '&contact=' + encodeURIComponent(contact) + '&vaccineCenter=' + encodeURIComponent(vaccineCenter) + '&vaccineType=' + encodeURIComponent(vaccineType);
            xhr.send(msg);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    let data = JSON.parse(xhr.responseText);
                    if (data['status']) {
                        document.getElementById("mHeader").style.background = "green";
                        document.getElementById("mFooter").style.background = "green";
                        document.getElementById("mBody").innerHTML = "<p>Appointment Success!</p>";
                        document.getElementById("mFooter").innerHTML = "<h3>Thank you!</h3>";
                        modal.style.display = "block";
                    } else {
                        // alert('appointment failed');
                        document.getElementById("mHeader").style.background = "red";
                        document.getElementById("mFooter").style.background = "red";
                        document.getElementById("mBody").innerHTML = "<p>Appointment Failed.</p>";
                        document.getElementById("mFooter").innerHTML = "<h3>Try Again!</h3>";
                        modal.style.display = "block";
                    }
                }
            }

        }

        // Get the modal
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>