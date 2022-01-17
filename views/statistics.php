<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
  <script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
  <title>Document</title>
  <style>
    .grid-container {
      display: grid;
      grid-template-columns: auto auto;
    }

    .grid-item {
      padding: 2%;
      font-size: 15pt;
      text-align: center;
      padding-left: 2%;
    }

    input,
    #district {
      width: 60%;
      padding-left: 2%;
    }

    .cover {
      background-color: rgb(0, 0, 0, 0.8);
      width: 60%;
      margin: auto;
      border-radius: 15px;
      color: white;
    }

    .item1 {
      grid-area: test;
    }

    .item2 {
      grid-area: dose_1;
    }

    .item3 {
      grid-area: dose_2;
    }

    .item4 {
      grid-area: dose_3;
    }

    .grid-container_1 {
      display: grid;
      grid-template-areas:
        'dose_1 dose_2 dose_3'
        'test test test';
      align-content: center;
      justify-content: center;
    }

    /* #piechart-test {
      position: absolute;
      left: 30%
    } */
  </style>
</head>

<body>
  <?php
  @include('navbar.php') ?>
  <br>
  <div class="cover">
    <div class="grid-container">
      <div class="grid-item"><label for="district">District:</label></div>
      <div class="grid-item">
        <select name="district" id="district">
          <option value="all">All</option>
          <?php
          require_once($_SERVER['DOCUMENT_ROOT'] . '/.utils/global.php');
          foreach (DISTRICTS as $type) {
          ?>
            <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
          <?php
          } ?>
        </select>
        <br>
      </div>
    </div>
  </div>
  <div class="grid-container_1">
    <div id="piechart-vaccination-dose-1" class="item2"></div>
    <div id="piechart-vaccination-dose-2" class="item3"></div>
    <div id="piechart-vaccination-dose-3" class="item4"></div>
    <div id="piechart-test" class="item1"></div>
  </div>

  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="/scripts/common.js"></script>
  <script src="/scripts/statistics.js"></script>
</body>

</html>