<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [['place' => 'General Hosp. Kalutara', 'Pfizer' => 30, 'Sinopharm' => 40], ['place' => 'Base Hosp. Horana', 'Aztraseneca' => 70, 'Sinopharm' => 40, 'Moderna' => 50], ['place' => 'MOH Gampaha', 'Pfizer' => 60, 'Moderna' => 100]];
    echo json_encode($data);
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
</head>

<body>
    <form>
        <label for="district">District:</label><br>
        <input type="text" id="district" name="district" value=""><br>

        <input type="button" value="Submit" onclick="submit1()">
    </form>
    <script type="text/javascript">
        function submit1() {
            let district = document.getElementById("district").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", document.URL, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("district=" + encodeURIComponent(district));
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    let data = JSON.parse(xhr.responseText);
                    console.log(data);
                }
            }
        }
    </script>
</body>

</html>