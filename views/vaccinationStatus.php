<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
  <!--link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet" /-->
  <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
  <title>Document</title>
  <style>
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

    /* 
    tr:nth-child(even) {
      background-color: #dddddd;
    } */

    body,
    html {
      margin: 0;
      padding: 0;
    }

    #div1 {
      font-size: 300%;
      font-family: "Oswald", sans-serif;
      color: brown;
      font-weight: bold;
      text-align: center;
    }

    .txt {
      font-size: 200%;
      font-family: "Oswald", sans-serif;
      color: black;
      font-weight: bold;
      position: relative;
    }

    .item3 {
      margin-top: 30px;
    }

    .item4 {
      width: 300px;
      margin: auto;
      margin-top: 60px;

    }

    .cover {
      background-color: rgb(0, 0, 0, 0.8);
      width: 60%;
      margin: auto;
      border-radius: 15px;
      color: white;
      padding: 2%;
    }

    h2 {
      color: white;
      padding-left: 0.5%;
    }

    .grid-container {
      display: grid;
      grid-template-columns: auto auto;
      padding: 10%;
    }

    .grid-item {
      padding-left: 2%;
      font-size: 15pt;
      text-align: center;
    }

    input {
      width: 60%;
      padding-left: 4%;
    }

    label {
      float: left;
      padding-left: 8%;
    }

    .cover h1 {
      text-align: center;
    }

    .cover button {
      width: 40%;
      position: relative;
      left: 30%;
    }

    nav a {
      margin-right: 1%;
    }

    input:hover,
    select:hover {
      border: 2px solid blue;
    }
  </style>
</head>

<body>
  <?php
  @include('navbar.php') ?>
  <br>



  <div class="cover">
    <h1>View Vaccination Status</h1>
    <br>
    <form>
      <div class="grid-contener">
        <div class="grid-item"><label for="inputID">Enter ID:</label></div>
        <div class="grid-item"><input type="text" id="inputID" onkeypress="keypress(event);"></div>
      </div>
      <br>
      <button id="submitBtn" type="button" class="btn btn-success" onclick="getStatus()">Submit</button>
    </form>
    <br>
    <div id="results" class="item4"></div>
  </div>

  <?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/modal.php');
  addModal('Vaccination Status');
  ?>

  <script src="/scripts/common.js"></script>
  <script src="/scripts/vaccinationStatus.js"></script>
</body>

</html>