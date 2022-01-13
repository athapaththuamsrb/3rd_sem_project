<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Stock</title>

  <link rel="stylesheet" type="text/css" href="/styles/all.css" />
  <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
  <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
    }

    h1,
    label {
      color: white;
    }

    body,
    html {
      margin: 0;
      padding: 0;
    }

    .container {
      background-color: rgb(0, 0, 0, 0.8);
      border-top-left-radius: 15px;
      border-bottom-right-radius: 15px;
      width: 55%;
      padding: 2%;
    }

    .container:hover {
      background-color: black;
    }

    input:hover,
    select:hover {
      border: 2px solid blue;
    }

    button:hover {
      -ms-transform: scale(1.2);
      /* IE 9 */
      -webkit-transform: scale(1.2);
      /* Safari 3-8 */
      transform: scale(1.2);
    }

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

    .grid-container {
      display: grid;
      grid-template-columns: auto auto;
      padding: 10px;
    }

    .grid-item {
      font-size: 15pt;
      text-align: center;
      padding: 1%;
      padding-bottom: 4%;
    }

    input,
    select {
      width: 80%;
      padding-left: 4%;
      padding-right: 1%;
    }

    label {
      float: left;
      padding-left: 15%;
    }

    h1 {
      text-align: center;
    }

    .container button {
      width: 40%;
      position: relative;
      left: 30%;
      padding: 5%;
    }

    nav a {
      margin-right: 1%;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Vaccination Center</a>
      <a href="/vaccination/index.php"><button type="button" class="btn btn-primary">Dashboard</button></a>
    </div>


  </nav>
  <br><br>
  <form>
    <div class="container">
      <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
          <h1>Add stock</h1>
        </div>
        <div class="col-4"></div>
      </div>
      <div class="grid-container">

        <div class="grid-item"><label for="date">Date:</label></div>
        <div class="grid-item"> <input type="date" id="date" name="date" /></div>

        <div class="grid-item"><label for="type">Vaccine Type:</label></div>
        <div class="grid-item">
          <select name="type" id="type">
            <option value="Pfizer">Pfizer</option>
            <option value="Sinopharm">Sinopharm</option>
            <option value="Aztraseneca">Aztraseneca</option>
            <option value="Moderna">Moderna</option>
          </select>
        </div>

        <div class="grid-item"><label for="dose">Dose:</label></div>
        <div class="grid-item"><input type="number" id="dose" name="dose" placeholder="Dose" min="1" max="3" pattern="[0-9]+" /></div>

        <div class="grid-item"><label for="amount">Amount:</label></div>
        <div class="grid-item"><input type="number" id="amount" name="amount" placeholder="Amount" min=0 /></div>

        <div class="grid-item"><label for="onlineAmount">Online Booking Amount:</label></div>
        <div class="grid-item"><input type="number" id="onlineAmount" name="onlineAmount" placeholder="Online booking amount" min=0 /></div>
      </div>
      <button type="button" value="Submit" class="btn btn-success" onclick="submitStock()">Submit</button>
      <br>
    </div>
  </form>

  <?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/modal.php');
  addModal('Add Stock');
  ?>

  <script src="/scripts/common.js"></script>
  <script src="/scripts/vaccination/addStock.js"></script>
</body>

</html>