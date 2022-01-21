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
    html,
    body {
      margin: 0;
      padding: 0;
      background-color: #A9A9A9;
    }

    html {
      overflow-x: scroll;
      overflow-y: scroll;
    }

    .cover {
      background-color: rgb(0, 0, 0, 0.8);
      width: 800px;
      margin: auto;
    }

    .cover-up {
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }

    .cover-down {
      border-bottom-left-radius: 15px;
      border-bottom-right-radius: 15px;
    }

    .cover:hover {
      background-color: black;
    }

    button:hover {
      -ms-transform: scale(1.2);
      /* IE 9 */
      -webkit-transform: scale(1.2);
      /* Safari 3-8 */
      transform: scale(1.2);
    }

    .buttons {
      text-align: center;
      margin: 2%;
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
      /* background-color: rgb(0, 0, 0, 0.8); */
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

    .grid-container {
      display: grid;
      grid-template-columns: auto auto;
      padding: 10%;
    }

    .grid-item {
      font-size: 15pt;
      text-align: left;
    }

    input,
    select,
    textarea {
      width: 50%;
      padding-left: 1%;
      padding-right: 1%;
    }

    .tst_type {
      width: 5%;
    }

    input:hover,
    select:hover,
    textarea:hover {
      border: 2px solid blue;
    }

    label {
      float: left;
      color: white;
      width: 40%;
      text-align: left;
      padding-left: 10%;
    }

    h1 {
      text-align: center;
    }

    .cover button {
      width: 40%;
      position: relative;
      left: 30%;
    }
  </style>
</head>

<body>
  <?php
  @include('navbar.php') ?>
  <br>
  <div class="cover-up cover">
    <div class="topic">
      <h1>Add data for Testing</h1>
    </div>

    <form id="application" method="post">
      <div class="grid-contener">
        <div class="grid-item"><label for="id">
            <lable class="field">ID:</lable>
          </label></div>
        <div class="grid-item"><input placeholder="ID" type="text" id="id" name="id" onkeypress="keypress(event, 0);" size="12" required /></div>
      </div>
      <br>
      <button id="submitButton1" type="button" name="submit" class="btn btn-success" onclick="getDetails()">
        Submit
      </button>
      <br><br>
    </form>
  </div>
  <!-- second form -->
  <div class="cover-down cover">
    <div id="hide">
      <div class="topic">
        <h1>Add test record</h1>
      </div>

      <form id="application" method="post">
        <div class="grid-contener">
          <div class="grid-item">
            <label for="district">
              <lable class="field">District:</lable>
            </label>
          </div>
          <div class="grid-item">
            <select name="district" id="district" oninput="this.className = ''">
              <?php
              require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/global.php');
              foreach (DISTRICTS as $type) {
              ?>
                <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
              <?php
              } ?>
            </select>
          </div>
          <br>
          <div class="grid-item">
            <label for="name">
              <lable class="field">Name:</lable>
            </label>
          </div>
          <div class="grid-item">
            <input placeholder="Name" type="text" id="name" name="name" onkeypress="keypress(event, 'address');" required />
          </div>
          <br>
          <div class="grid-item">
            <label for="Address">
              <lable class="field">Resident Address:</lable>
            </label>
          </div>
          <div class="grid-item">
            <textarea placeholder="Resident Address" type="text" id="address" name="address" onkeypress="keypress(event, 'email');" required /></textarea>
          </div>
          <br>
          <div class="grid-item">
            <label for="email">
              <lable class="field">Email Address:</lable>
            </label>
          </div>
          <div class="grid-item">
            <input placeholder="Email Address" type="email" id="email" name="email" onkeypress="keypress(event, 'ContactNo');" />
          </div>
          <br>
          <div class="grid-item">
            <label for="ContactNo">
              <lable class="field">Contact Number:</lable>
            </label>
          </div>
          <div class="grid-item">
            <input placeholder="0123456789" type="tel" id="ContactNo" pattern="[0-9]{10}" size="12" name="contact" value="" />
          </div>
          <br>
          <div class="grid-item">
            <label for="Type">
              <lable class="field">Test Type:</lable>
            </label>
          </div>
          <div class="grid-item"></div>
          <br>
          <br>
          <?php
          require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/global.php');
          foreach (TESTS as $type) {
          ?>
            <div class="grid-item"><label for="<?php echo $type; ?>"><?php echo $type; ?></label></div>
            <div class="grid-item"><input type="radio" class="tst_type" name="type" id="<?php echo $type; ?>" value="<?php echo $type; ?>" /></div>
          <?php
          } ?>
        </div>
        <br>
        <button id="submitButton2" type="button" name="submit" class="btn btn-success" onclick="submitRecord()">
          Submit
        </button>
        <br><br>
      </form>
    </div>
  </div>

  <?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/modal.php');
  addModal('Add Record');
  ?>
  <script src="/scripts/common.js"></script>
  <script src="/scripts/testing/addRecord.js"></script>
</body>

</html>