<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  if (isset($_POST['ID']) && $_POST['ID']){
    $id = $_POST['ID'];
    if ($id === '111'){
      $data = array('dose'=>'1');
    }else{
      $data = array('dose'=>'2', 'name'=>'superman', 'previous'=>array('key'=>'value'));
    }
    echo json_encode($data);
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
        background: url("/image/Covid-19-Test-and-Vaccine.jpg") no-repeat
          center;
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
        right: 100%; /* To the left of the tooltip */
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
    </style>
  </head>
  <body>
    <br /><br /><br />
    <div class="topic"><h1>Add data for Vaccination</h1></div>
    <div id="cover">

      <form id="application"  method="post">
        <div id="field">
          <br />
          <label for="nic"><h2 class="field">Nic</h2></label>
          <input placeholder="Nic" type="text" id="nic" name="ID" required />
        </div>
        <div class="buttons">
          <button
            id="submitButton1"
            type="button"
            name="submit"
            onclick="submit1()"
          >
            Submit
          </button>
        </div>
        <p id="other"><a href="./">Do you need to go back?</a></p>
      </form>

    </div>
    <br /><br /><br />
    <!-- secound form -->
    <div class="topic"><h1>Creat account</h1></div>
    <div id="cover">
      <form id="application" action="/signUp" method="post">
        <div id="field">
          <br />
          <label for="nic"><h2 class="field">Nic</h2></label>
          <input placeholder="Nic" type="text" id="nic2" name="nic" required />
        </div>
        <div id="field">
          <br />
          <label for="firestName"><h2 class="field">Firest name</h2></label>
          <input
            placeholder="firest name"
            type="text"
            id="firestName"
            name="firestName"
            required
          />
        </div>
        <div id="field">
          <br />
          <label for="secoundName"><h2 class="field">secound name</h2></label>
          <input
            placeholder="secound name"
            type="text"
            id="secoundName"
            name="secoundName"
            required
          />
        </div>
        <div class="textbox">
          <p class="field">Firest doce:</p>
          <label for="Type"><h2 class="field">Vaccination Type</h2></label>
          <br />
          <div id="type">
            <label for="Pfizer">Pfizer</label>
            <input
              type="radio"
              name="vaccination_type1"
              id="Pfizer"
              value="Pfizer"
              checked
            />
            <br />
            <label for="AstraZeneca">AstraZeneca</label>
            <input
              type="radio"
              name="vaccination_type1"
              id="AstraZeneca"
              value="AstraZeneca"
            />
            <br />
          </div>
        </div>
        <div class="textbox">
          <p class="field">Secound doce:</p>
          <label for="Type"><h2 class="field">Vaccination Type</h2></label>
          <br />
          <div id="type">
            <label for="Pfizer">Pfizer</label>
            <input
              type="radio"
              name="vaccination_type2"
              id="Pfizer"
              value="Pfizer"
              checked
            />
            <br />
            <label for="AstraZeneca">AstraZeneca</label>
            <input
              type="radio"
              name="vaccination_type2"
              id="AstraZeneca"
              value="AstraZeneca"
            />
            <br />
          </div>
        </div>
        <label for="Email"><h2 class="field">Email Address</h2></label>
        <input
          placeholder="Email Address"
          type="email"
          id="email"
          name="email"
          required
        />

        <label for="ContactNo"><h2 class="field">Contact Number</h2></label>
        <input
          placeholder="0123456789"
          type="tel"
          id="ContactNo"
          pattern="[0-9]{10}"
          name="telephone"
          required
        />
        <div class="buttons">
          <button
            id="submitButton2"
            type="button"
            name="submit"
            onclick="submit2()"
          >
            Submit
          </button>
        </div>
        <p id="other"><a href="./">Do you need to go back?</a></p>
      </form>
    </div>
    <script type="text/javascript">
      function submit1(){
        let nic = document.getElementById("nic").value;
        
        var xhr = new XMLHttpRequest();
        xhr.open("POST",document.URL,true);
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xhr.send("ID="+encodeURIComponent(nic));
        // console.log("ID="+encodeURIComponent(nic));
      }

      function submit2(){
        let nic = document.getElementById("nic2").value;
        let firstName = document.getElementById("firestName").value;
        let secondName = document.getElementById("secoundName").value;
        let firstVaccineType = document.querySelector( 'input[name="vaccination_type1"]:checked').value;
        let secondVaccineType = document.querySelector( 'input[name="vaccination_type2"]:checked').value;
        let email = document.getElementById("email").value;
        let contactNo = document.getElementById("ContactNo").value;

        
        var xhr = new XMLHttpRequest();
        xhr.open("POST",document.URL,true);
        xhr.setRequestHeader("Content-Type","application/json;charset=UTF-8");
        xhr.send({
          nic,
          firstName,
          secondName,
          firstVaccineType,
          secondVaccineType,
          email,
          contactNo,
        });
        // console.log({
        //   "nic":nic,
        //   "firstName":firstName,
        //   "secondName":secondName,
        //   "firstVaccineType":firstVaccineType,
        //   "secondVaccineType":secondVaccineType,
        //   "email":email,
        //   "contactNo":contactNo,
        // });
        // console.log({
        //   nic,
        //   firstName,
        //   secondName,
        //   firstVaccineType,
        //   secondVaccineType,
        //   email,
        //   contactNo,
        // });
      }
    </script>
  </body>
</html>
