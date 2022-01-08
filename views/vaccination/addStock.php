<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Vaccine Centre Admin Dashboard</title>

  <link rel="stylesheet" type="text/css" href="/styles/all.css" />
  <link rel="stylesheet" type="text/css" href="/styles/modal.css" />
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
      /* background: url("/image/Covid-19-Test-and-Vaccine.jpg") no-repeat center;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      font-family: sans-serif; */
    }

    .container {
      background-color: rgb(0, 0, 0, 0.8);
      border-top-left-radius: 10%;
      border-bottom-right-radius: 10%;
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
    }

    label {
      float: left;
      padding-left: 15%;
    }

    h1 {
      text-align: center;
    }

    button {
      width: 40%;
      position: relative;
      left: 30%;
      padding: 5%;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Vaccination Center</a>
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

  <!-- Trigger/Open The Modal -->
  <!-- <button id="myBtn">Open Modal</button> -->
  <!-- The Modal -->
  <div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header" id="mHeader">
        <span class="close" id="close-span">&times;</span>
        <h2>Add Stock</h2>
      </div>
      <div class="modal-body" id="mBody">
        <p>Success!</p>
      </div>
      <div class="modal-footer" id="mFooter">
        <h3>Thank you!</h3>
      </div>
    </div>
  </div>
  <script src="/scripts/common.js"></script>
  <script src="/scripts/modal.js"></script>
  <script src="/scripts/vaccination/addStock.js"></script>
</body>

</html>