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

        <label for="date">Date:</label><br>
        <input type="text" id="date" name="date" value=""><br>

        <input type="button" value="Submit" onclick="submit1()">
    </form>
    <ul id="centers">

    </ul>
    <input type="button" value="select" onclick="submit2()">
    <script type="text/javascript">
        function submit1() {
            let district = document.getElementById("district").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", document.URL, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("district=" + encodeURIComponent(district));
            // xhr.onreadystatechange = function() {
            //     if (xhr.readyState == XMLHttpRequest.DONE) {
            //         let data = JSON.parse(xhr.responseText);
            //         console.log(data);
            //     }
            // }
            console.log("hi")
            let output = document.getElementById("centers");
            let data = [{
                    place: 'General Hosp. Kalutara',
                    Pfizer: 30,
                    Sinopharm: 40
                },
                {
                    place: 'Base Hosp. Horana',
                    Aztraseneca: 70,
                    Sinopharm: 40,
                    Moderna: 50
                },
                {
                    place: 'MOH Gampaha',
                    Pfizer: 60,
                    Moderna: 100
                }
            ]
            var content = ""
            var possibleVaccines = ["Pfizer", "Sinopharm", "Aztraseneca", "Moderna"]
            for (index = 0; index < data.length; index++) {
                // console.log(data[index]["place"])
                // var pl = data[index]["place"];
                content += "<li>" + data[index]["place"] +"<ol>";
                for (i = 0; i < possibleVaccines.length; i++) {
                    if (data[index][possibleVaccines[i]] != undefined) {
                        var text =data[index]["place"]+"?"+[possibleVaccines[i]];
                        // const myArray = text.split("&");
                        // console.log(myArray)
                        var editText = text.replace(/ /g,"@")
                        // console.log(editText)
                        content += "<li>" + [possibleVaccines[i]] + ":" + data[index][possibleVaccines[i]] 
                                    +'<input type = "radio"  name ="appoinment" id ="Testing_center" value ='+editText+" /> "+ "</li>"
                    }
                }
                content += "</ol></li>"
            }
            output.innerHTML = content;
        }

        function submit2(){
            var text = document.querySelector('input[name="appoinment"]:checked').value.replace(/@/g," ").split("?");
            // var editedText = text.replace(/@/g," ").split("&")
            // var text = document.querySelector('input[name="appoinment"]:checked').className;
            let district = document.getElementById("district").value;
            let date = document.getElementById("date").value;
            let vaccineCenter = text[0]
            let vaccineType = text[1]

            // console.log(text)

            var xhr = new XMLHttpRequest();
            xhr.open("POST", document.URL, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            // xhr.send("district=" + encodeURIComponent(district)+"&date=" + encodeURIComponent(date)+"&vaccineCenter=" + encodeURIComponent(vaccineCenter)+"&vaccineType=" + encodeURIComponent(vaccineType));
            console.log("district=" + encodeURIComponent(district)+"&date=" + encodeURIComponent(date)+"&vaccineCenter=" + encodeURIComponent(vaccineCenter)+"&vaccineType=" + encodeURIComponent(vaccineType))
        }
    </script>
</body>

</html>