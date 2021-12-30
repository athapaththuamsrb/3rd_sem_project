<!DOCTYPE html>
<html>

<head>
  <title>Request Application</title>
  <link rel="stylesheet" type="text/css" href="/styles/all.css" />
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="/styles/all.css" />
  <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
  <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
  <style type="text/css">
    * {
      margin: 0;
      padding: 0;
    }

    h2,
    h1,
    label {
      color: white;
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

    .cover {
      background-color: rgb(0, 0, 0, 0.8);
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
      background-color: rgb(0, 0, 0, 0.8);
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

    #name,
    #id,
    #district,
    #address,
    #email,
    #ContactNo,
    #type {
      position: relative;
      line-height: 40px;
      border-radius: 6px;
      padding: 0 37px;
      font-size: 16px;
    }

    #name {
      left: 29%;
    }

    #id {
      left: 32%;
    }

    #district {
      left: 25%;
      height: 40%;
    }

    #address {
      left: 15%;
    }

    #email {
      left: 18%;
    }

    #ContactNo {
      left: 16%;
    }

    #type {
      left: 50%;
    }

    #invalid {
      width: 72%;
      height: 40px;
      position: relative;
      text-align: center;
      left: 13%;
    }

    .item4 {
      /* height: 300px; */
      width: 300px;
      margin: auto;
      margin-top: 30px;
      margin-bottom: 30px;
    }

    #type>label {
      padding-right: 3px;
      width: 100px;
    }

    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td,
    th {
      border: 1px solid black;
      text-align: left;
      padding: 8px;
    }

    th {
      color: black;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }

    tr:nth-child(odd) {
      background-color: #dddddd;
    }

    #hide {
      display: none;
    }
  </style>
</head>

<body>
  <br /><br /><br />
  <div class="topic">
    <h1>Add data for Vaccination</h1>
  </div>
  <div class="cover">
    <form id="application" method="post">
      <div id="field">
        <br />
        <label for="id">
          <h2 class="field">ID</h2>
        </label>
        <input placeholder="ID" type="text" id="id" name="id" required />
      </div>
      <div class="buttons">
        <button id="submitButton1" type="button" name="submit" class="btn btn-success" onclick="getDetails()">
          Submit
        </button>
      </div>
      <p id="other"><a href="./">Do you need to go back?</a></p>
    </form>
  </div>
  <div class="item4">
    <table id="resultTable"></table>
  </div>
  <!-- second form -->
  <div id="hide">
    <div class="topic">
      <h1>Add vaccine record</h1>
    </div>
    <div class="cover">
      <form id="application" method="post">
        <div id="field">
          <br />
          <label for="district">
            <h2 class="field">District:</h2>
          </label>
          <select name="district" id="district" oninput="this.className = ''">
            <option value="Colombo">Colombo</option>
            <option value="Gampaha">Gampaha</option>
            <option value="Kalutara">Kalutara</option>
            <option value="Galle">Galle</option>
            <option value="Matara">Matara</option>
            <option value="Hambantota">Hambantota</option>
            <option value="Kandy">Kandy</option>
            <option value="Matale">Matale</option>
            <option value="Nuwara Eliya">Nuwara Eliya</option>
            <option value="Anuradhapura">Anuradhapura</option>
            <option value="Polonnaruwa">Polonnaruwa</option>
            <option value="Puttalam">Puttalam</option>
            <option value="Kurunegala">Kurunegala</option>
            <option value="Kegalle">Kegalle</option>
            <option value="Ratnapura">Ratnapura</option>
            <option value="Trincomalee">Trincomalee</option>
            <option value="Batticaloa">Batticaloa</option>
            <option value="Ampara">Ampara</option>
            <option value="Badulla">Badulla</option>
            <option value="Monaragala">Monaragala</option>
            <option value="Jaffna">Jaffna</option>
            <option value="Kilinochchi">Kilinochchi</option>
            <option value="Mannar">Mannar</option>
            <option value="Mullaitivu">Mullaitivu</option>
            <option value="Vavuniya">Vavuniya</option>
          </select><br />
        </div>
        <div id="field">
          <br />
          <label for="name">
            <h2 class="field">Name</h2>
          </label>
          <input placeholder="Name" type="text" id="name" name="name" value="" required />
        </div>
        <div id="field">
          <label for="Address">
            <h2 class="field">Resident Address</h2>
          </label>
          <textarea placeholder="Resident Address" type="text" id="address" name="address" value="" required /></textarea>
        </div>
        <br /><br />
        <div id="field">
          <label for="email">
            <h2 class="field">Email Address</h2>
          </label>
          <input placeholder="Email Address" type="email" id="email" name="email" value="" />
        </div>
        <div id="field">
          <label for="ContactNo">
            <h2 class="field">Contact Number</h2>
          </label>
          <input placeholder="0123456789" type="tel" id="ContactNo" pattern="[0-9]{10}" name="contact" value="" />
        </div>
        <div class="textbox">
          <label for="Type">
            <h2 class="field">Vaccination Type</h2>
          </label>
          <br />
          <div id="type">
            <label for="Pfizer">Pfizer</label>&nbsp;&nbsp;
            <input type="radio" name="type" id="Pfizer" value="Pfizer" />
            <br />
            <label for="Aztraseneca">AstraZeneca</label>&nbsp;&nbsp;
            <input type="radio" name="type" id="AstraZeneca" value="Aztraseneca" />
            <br />
            <label for="Sinopharm">Sinopharm</label>&nbsp;&nbsp;
            <input type="radio" name="type" id="Sinopharm" value="Sinopharm" />
            <br />
            <label for="Moderna">Moderna</label>&nbsp;&nbsp;
            <input type="radio" name="type" id="Moderna" value="Moderna" />
            <br /><br />
          </div>
        </div>
        <div id="field">
          <div class="buttons">
            <button id="submitButton2" type="button" name="submit" class="btn btn-success" onclick="submitRecord()">
              Submit
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script type="text/javascript" src="/scripts/common.js"></script>
  <script type="text/javascript" src="/scripts/vaccination/addRecord.js"></script>
</body>

</html>