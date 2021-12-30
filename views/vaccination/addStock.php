<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Vaccine Centre Admin Dashboard</title>

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
      margin-top: 10px;
      background: url("/image/Covid-19-Test-and-Vaccine.jpg") no-repeat center;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      font-family: sans-serif;
    }

    #date,
    #type,
    #dose,
    #amount,
    #onlineAmount {
      position: relative;
      line-height: 40px;
      border-radius: 6px;
      padding: 0 37px;
      font-size: 16px;
    }

    #date {
      left: 220px;
    }

    #dose {
      left: 215px;
    }

    #amount {
      left: 195px;
    }

    #onlineAmount {
      left: 85px;
    }

    #type {
      left: 160px;
    }

    .container {
      background-color: rgb(0, 0, 0, 0.8);
      border-radius: 5%;
    }

    .btn {
      width: 200px;
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
  </style>
</head>

<body>
  <form>
    <div class="container">
      <br /><br />
      <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
          <h1>Add stock</h1>
        </div>
        <div class="col-4"></div>
      </div>
      <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
          <label for="date">Date:</label>
          <input type="date" id="date" name="date" value="" /><br />
        </div>
        <div class="col-3"></div>
      </div>
      <br /><br />
      <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
          <label for="type">Vaccine Type:</label>
          <select name="type" id="type">
            <option value="Pfizer">Pfizer</option>
            <option value="Sinopharm">Sinopharm</option>
            <option value="Aztraseneca">Aztraseneca</option>
            <option value="Moderna">Moderna</option>
          </select>
        </div>
        <div class="col-3"></div>
      </div>
      <br /><br />
      <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
          <label for="dose">Dose:</label>
          <input type="number" id="dose" name="dose" value="" min="1" /><br />
        </div>
        <div class="col-3"></div>
      </div>
      <br /><br />
      <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
          <label for="amount">Amount:</label>
          <input type="number" id="amount" name="amount" value="" min=0 /><br />
        </div>
        <div class="col-3"></div>
      </div>
      <br /><br />
      <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
          <label for="onlineAmount">Online Booking Amount:</label>
          <input type="number" id="onlineAmount" name="onlineAmount" value="" min=0 />
          <div class="col-3"></div>
          <br />
        </div>
      </div>
      <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
          <button type="button" value="Submit" class="btn btn-primary" onclick="submitStock()">Submit</button>
        </div>
        <div class="col-4"></div>
      </div>
      <br /><br />
    </div>
  </form>

  <script type="text/javascript" src="/scripts/common.js"></script>
  <script type="text/javascript" src="/scripts/vaccination/addStock.js"></script>
</body>

</html>