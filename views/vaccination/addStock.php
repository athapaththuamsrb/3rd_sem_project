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
          <input type="number" id="dose" name="dose" value="" /><br />
        </div>
        <div class="col-3"></div>
      </div>
      <br /><br />
      <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
          <label for="amount">Amount:</label>
          <input type="number" id="amount" name="amount" value="" /><br />
        </div>
        <div class="col-3"></div>
      </div>
      <br /><br />
      <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
          <label for="onlineAmount">Online Booking Amount:</label>
          <input type="number" id="onlineAmount" name="onlineAmount" value="" />
          <div class="col-3"></div>
          <br />
        </div>
      </div>
      <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
          <input type="button" value="Submit" class="btn btn-primary" onclick="submit1()" />
        </div>
        <div class="col-4"></div>
      </div>
      <br /><br />
    </div>

  </form>

  <script src="/scripts/common.js"></script>
  <script type="text/javascript">
    function submit1() {
      let date = document.getElementById("date").value;
      let type = document.getElementById("type").value;
      let dose = document.getElementById("dose").value;
      let amount = document.getElementById("amount").value;
      let onlineAmount = document.getElementById("onlineAmount").value;
      amount = parseInt(amount);
      onlineAmount = parseInt(onlineAmount);
      dose = parseInt(dose);
      if (!date || !type || !dose || !amount || !onlineAmount || dose <= 0 || amount <= 0 || onlineAmount < 0 || onlineAmount > amount) {
        alert("Entered data is invalid");
        return false;
      }

      let xhrBuilder = new XHRBuilder();
      xhrBuilder.addField('date', date);
      xhrBuilder.addField('type', type);
      xhrBuilder.addField('dose', dose);
      xhrBuilder.addField('amount', amount);
      xhrBuilder.addField('onlineAmount', onlineAmount);
      var xhr = new XMLHttpRequest();
      xhr.open("POST", document.URL, true);
      xhr.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
      );
      /*let senddata = `date=${encodeURIComponent(
          date
        )}&type=${encodeURIComponent(
          type
        )}&dose=${dose}&amount=${amount}&onlineAmount=${onlineAmount}`;*/
      xhr.send(xhrBuilder.build());
      xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
          try {
            let data = JSON.parse(xhr.responseText);
            alert(data["success"] === true ? "Success" : "Failed!");
            if (data["success"]){
              //clear form
            }
          } catch (error) {
            alert("Error occured");
          }
        }
      };
    }
  </script>
</body>

</html>