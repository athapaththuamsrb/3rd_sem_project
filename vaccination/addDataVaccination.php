<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id']) && $_POST['id']) {
    require_once('../.utils/dbcon.php');
    $con = DatabaseConn::get_conn();
    if (isset($_POST['name']) && isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['district']) && $_POST['name'] && $_POST['type'] && $_POST['dose'] && $_POST['district']) {
      $token = $con->add_vaccine_record($_POST['id'], $_POST['name'], $_POST['district'], $_POST['type'], 'Colombo'); // Get place by centre account
      echo json_encode($token);
      die();
    } else {
      $id = $_POST['id'];
      $data = $con->get_vaccination_records($id, null);
      echo json_encode($data);
    }
  }
  die();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Request Application</title>
  <link rel="stylesheet" type="text/css" href="/styles/all.css" />
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style type="text/css">
    * {
      margin: 0;
      padding: 0;
      color: red;
    }

    #application {
      padding: 10px;
    }

    #loginButton {
      width: 250px;
      background-color: blue;
    }

    body,
    html {
      margin-top: 10px;
      background: url("/image/Covid-19-Test-and-Vaccine.jpg") no-repeat center;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      font-family: sans-serif;
    }

    html {
      overflow-x: scroll;
      overflow-y: scroll;
    }

    #cover {
      background-color: rgb(0, 0, 0, 0.6);
      width: 800px;
      margin: auto;
      border-bottom-left-radius: 15px;
      border-bottom-right-radius: 15px;
    }

    #other {
      text-align: left;
      padding: 20px;
    }

    #field {
      width: 100%;
      height: 100px;
    }

    .field {
      margin-left: 100px;
      width: 200 px;
      font-size: 18px;
      font-weight: 700;
    }

    #intro {
      text-align: center;
    }

    .buttons {
      text-align: center;
    }

    #submitButton {
      background-color: rgb(225, 220, 220);
      display: inline-block;
      font-size: 20px;
      text-align: center;
      border-radius: 12px;
      border: 2px solid black;
      padding: 5px 15px;
      outline: none;
      cursor: pointer;
      transition: 0.25px;
    }

    #hideWord {
      visibility: hidden;
      /* Position the tooltip */
      position: absolute;
      z-index: 1;
      font-size: 50%;
      background-color: red;
      padding-left: 2px;
    }

    #iconBack #hideWord::after {
      content: " ";
      position: absolute;
      top: 50%;
      right: 100%;
      /* To the left of the tooltip */
      margin-top: -5px;
      border-width: 5px;
      border-style: solid;
      border-color: transparent red transparent transparent;
    }

    #iconBack:hover #hideWord {
      visibility: visible;
    }

    .topic {
      width: 800px;
      background-color: rgb(0, 0, 0, 0.6);
      margin: auto;
      color: white;
      padding: 10px 0px 10px 0px;
      text-align: center;
      border-radius: 15px 15px 0px 0px;
    }

    #index {
      position: relative;
      line-height: 40px;
      border-radius: 6px;
      padding: 0 37px;
      font-size: 16px;
      left: 400px;
      top: -20px;
    }

    #Department {
      position: relative;
      line-height: 40px;
      border-radius: 6px;
      padding: 0 13px;
      font-size: 16px;
      left: 400px;
      top: -20px;
      margin-bottom: 15px;
      border: 2px solid black;
    }

    #firestName,
    #secoundName,
    #nic,
    #email,
    #ContactNo,
    #password,
    #confirmPW,
    #type,
    #Index,
    #fullName {
      position: relative;
      line-height: 40px;
      border-radius: 6px;
      padding: 0 37px;
      font-size: 16px;
      left: 400px;
      top: -37px;
    }

    #invalid {
      width: 72%;
      height: 40px;
      position: relative;
      text-align: center;
      left: 13%;
    }
    .item4{
        /* height: 300px; */
        width: 300px;
        margin: auto;
        margin-top: 30px;
        margin-bottom: 30px;
        
      }
      table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }

      td, th {
        border: 1px solid black;
        text-align: left;
        padding: 8px;
      }

      tr:nth-child(even) {
        background-color: #dddddd;
      }
      tr:nth-child(odd) {
        background-color: black;
      }
  </style>
</head>

<body>
  <br /><br /><br />
  <div class="topic">
    <h1>Add data for Vaccination</h1>
  </div>
  <div id="cover">

    <form id="application" method="post">
      <div id="field">
        <br />
        <label for="nic">
          <h2 class="field">Nic</h2>
        </label>
        <input placeholder="Nic" type="text" id="nic" name="ID" required />
      </div>
      <div class="buttons">
        <button id="submitButton1" type="button" name="submit" onclick="submit1()">
          Submit
        </button>
      </div>
      <p id="other"><a href="./">Do you need to go back?</a></p>
    </form>

  </div>
  <div class="item4">
        <table id="resultTable">
        </table>
  </div>
  <!-- secound form -->
  <div class="topic">
    <h1>Creat account</h1>
  </div>
  <div id="cover">
    <form id="application"  method="post">
      <div id="field">
        <br />
        <label for="nic">
          <h2 class="field">Nic</h2>
        </label>
        <input placeholder="Nic" type="text" id="nic2" name="nic" required />
      </div>
      <div id="field">
        <br />
        <label for="district">
          <h2 class="field">Firest name</h2>
        </label>
        <input placeholder="District" type="text" id="district" name="district" value="" required />
      </div>
      <div id="field">
        <br />
        <label for="firestName">
          <h2 class="field">Firest name</h2>
        </label>
        <input placeholder="firest name" type="text" id="firestName" name="firestName" value="" required />
      </div>
      <div class="textbox">
        <label for="Type">
          <h2 class="field">Vaccination Type</h2>
        </label>
        <br />
        <div id="type">
          <label for="Pfizer">Pfizer</label>
          <input type="radio" name="vaccination_type" id="Pfizer" value="Pfizer" />
          <br />
          <label for="AstraZeneca">AstraZeneca</label>
          <input type="radio" name="vaccination_type" id="AstraZeneca" value="AstraZeneca" />
          <br />
        </div>
      </div>
      <!-- <div class="textbox">
        <p class="field">Secound doce:</p>
        <label for="Type">
          <h2 class="field">Vaccination Type</h2>
        </label>
        <br />
        <div id="type">
          <label for="Pfizer">Pfizer</label>
          <input type="radio" name="vaccination_type2" id="Pfizer2" value="Pfizer" />
          <br />
          <label for="AstraZeneca">AstraZeneca</label>
          <input type="radio" name="vaccination_type2" id="AstraZeneca2" value="AstraZeneca" />
          <br />
        </div>
      </div> -->
      <label for="Email">
        <h2 class="field">Email Address</h2>
      </label>
      <input placeholder="Email Address" type="email" id="email" name="email" value="" required />

      <label for="ContactNo">
        <h2 class="field">Contact Number</h2>
      </label>
      <input placeholder="0123456789" type="tel" id="ContactNo" pattern="[0-9]{10}" name="telephone" value="" required />
      <div class="buttons">
        <button id="submitButton2" type="button" name="submit" onclick="submit2()">
          Submit
        </button>
      </div>
      <p id="other"><a href="./">Do you need to go back?</a></p>
    </form>
  </div>
  <script type="text/javascript">
    function submit1() {
      let nic = document.getElementById("nic").value;

      var xhr = new XMLHttpRequest();
      xhr.open("POST", document.URL, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send("id=" + encodeURIComponent(nic));
      xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
          let data = JSON.parse(xhr.responseText);
          console.log(data);
          // document.getElementById("firestName").value=data["name"];
          // document.getElementById("secoundName").value=data["name"];

          // if(data["doses"][0]["type"]=="Pfizer"){
          //   document.getElementById("Pfizer1").checked=true;
          // }else if(data["doses"][0]["type"]=="AstraZeneca"){
          //   document.getElementById("AstraZeneca1").checked=true;
          // }

          // if(data["doses"][1]["type"]=="Pfizer"){
          //   document.getElementById("Pfizer2").checked=true;
          // }else if(data["doses"][1]["type"]=="AstraZeneca"){
          //   document.getElementById("AstraZeneca2").checked=true;
          // }
        let output = document.getElementById("resultTable");
        var tableContent = "<tr><th>Type</th><th>Date</th></tr>"
        for (index = 0; index < data["doses"].length; index++) {
          tableContent += "<tr><td>" + data["doses"][index]["type"] + "</td>"
                          + "<td>" + data["doses"][index]["date"] + "</td></tr>";
        }
        output.innerHTML = tableContent;

          // document.getElementById("email").value=data["email"];
          // document.getElementById("ContactNo").value=data["contactNo"];
        }
      }
    }

    function submit2() {
      let nic = document.getElementById("nic2").value;
      let firstName = document.getElementById("firestName").value;
      let district = document.getElementById("district").value;
      let vaccineType = document.querySelector('input[name="vaccination_type"]:checked').value;
      // let secondVaccineType = document.querySelector('input[name="vaccination_type2"]:checked').value;
      let email = document.getElementById("email").value;
      let telephone = document.getElementById("ContactNo").value;


      var xhr = new XMLHttpRequest();
      xhr.open("POST", document.URL, true);
      xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      // xhr.send({
      //   nic,
      //   firstName,
      //   secondName,
      //   firstVaccineType,
      //   secondVaccineType,
      //   email,
      //   contactNo,
      // });
      xhr.send(encodeURIComponent("nic=")+encodeURIComponent(nic)+encodeURIComponent("&district=")+encodeURIComponent(district)+encodeURIComponent("&firstName=")+encodeURIComponent(firstName)+
      encodeURIComponent("&firstName=")+encodeURIComponent(firstName)+ encodeURIComponent("&vaccination_type=")+encodeURIComponent(vaccineType)+
      encodeURIComponent("&email=")+encodeURIComponent(email)+encodeURIComponent("&telephone=")+encodeURIComponent(telephone))
      // console.log({
      //   "nic":nic,
      //   "firstName":firstName,
      //   "vaccineType":vaccineType,
      //   "email":email,
      //   "telephone":telephone,
      // });
      // console.log(encodeURIComponent("nic=")+encodeURIComponent(nic)+encodeURIComponent("&firstName=")+encodeURIComponent(firstName)+
      // encodeURIComponent("&firstName=")+encodeURIComponent(firstName)+ encodeURIComponent("&vaccination_type=")+encodeURIComponent(vaccineType)+
      // encodeURIComponent("&email=")+encodeURIComponent(email)+encodeURIComponent("&telephone=")+encodeURIComponent(telephone));
    }
  </script>
</body>

</html>