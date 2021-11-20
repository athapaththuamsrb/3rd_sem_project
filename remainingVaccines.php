<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remaining Vaccines</title>

    <script src="./jquery.min.js"></script>

    <style>
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }

      td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
      }

      tr:nth-child(even) {
        background-color: #dddddd;
      }
      .item4{
        /* height: 300px; */
        width: 300px;
        margin: auto;
        margin-top: 60px;
        
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

        <input type="button" value="Submit" onclick="submit1()">

        <div class="item4">
        <table id="resultTable">
        </table>
      </div>
    </form>


    <script type="text/javascript">

        if (typeof jQuery != "undefined"){
            alert("working")
        }


        function submit1() {
            let district = document.getElementById("districts").value;

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
                    place: 'MOHGampaha',
                    Pfizer: 60,
                    Moderna: 100
                }
            ]

            let output = document.getElementById("resultTable");
            var tableContent = "<tr><th>Place</th><th></th></tr>"
            for (index = 0; index < data.length; index++) {
                var place = data[index]["place"]
                tableContent += "<tr><td>" + data[index]["place"] + "</td>" +
                    "<td>" +'<input type="button" value="Show" onclick="submit2()">' + "</td></tr>";
            }
            output.innerHTML = tableContent;
        }

        function submit2(){
            console.log("hi")
        }
    </script>

</body>

</html>