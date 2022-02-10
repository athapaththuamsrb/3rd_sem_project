<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="/styles/all.css" />
  <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
  <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
  <title>Vaccine Certificate</title>
</head>
<style>
  body,
  html {
    padding: 0;
    margin: 0;
    background-color: #A9A9A9;
  }

  .cover {
    background-color: rgb(0, 0, 0, 0.8);
    width: 45%;
    margin: auto;
    border-radius: 15px;
    color: white;
    padding: 2%;
  }

  h1 {
    text-align: center;
  }

  h2 {
    color: white;
    padding-left: 2%;
  }

  .grid-container {
    display: grid;
    grid-template-columns: auto auto;
    padding: 1%;
  }

  .grid-item {
    font-size: 15pt;
    text-align: center;
    padding-right: 5%;
    padding-bottom: 5%;
  }

  input {
    width: 60%;
    padding-left: 5%;
  }

  select {
    width: 100%;
  }

  label {
    float: left;
    padding-left: 5%;
  }
/*
  select:hover,
  input:hover {
    border: 2px solid blue;
  }
*/
  .cover button {
    width: 40%;
    position: relative;
    left: 30%;
  }
</style>

<body>

  <?php
  @include('navbar.php') ?>
  <br>
  <div class="cover">
    <h1>Add Testing Results</h1>
    <div class="grid-container">
      <div class="grid-item"><label for="inputToken" class="form-label txt">Enter Token:</label></div>
      <div class="grid-item"><input type="text" class="form-control" id="inputToken" onkeypress="keypress(event, 1);" size="6"></div>
      <div class="grid-item"><label for="result" class="form-label txt">Enter Result:</label></div>
      <div class="grid-item">
        <select name="type" id="result">
          <option value="">--select--</option>
          <option value="Positive">Positive</option>
          <option value="Negative">Negative</option>
        </select>
      </div>
      <br>
    </div>
    <button id="submitBtn" type="button" class="btn btn-success" onclick="submitResult();">Add Result</button>
    <br>
  </div>
  <?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/modal.php');
  addModal('Add Result');
  ?>
  <script src="/scripts/common.js"></script>
  <script src="/scripts/testing/addTestResult.js"></script>
</body>

</html>