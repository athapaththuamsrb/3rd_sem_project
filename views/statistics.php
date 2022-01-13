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
    #districts {
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
      <div class="grid-item"><label for="districts">Districts:</label></div>
      <div class="grid-item">
        <select name="districts" id="districts">
          <option value="Sri-Lanka">All</option>
          <option value="Colombo">Colombo</option>
          <option value="Kalutara">Kalutara</option>
          <option value="Gampaha">Gampaha</option>
          <option value="Puttalam">Puttalam</option>
          <option value="Kurunegala">Kurunegala</option>
          <option value="Anuradhapura">Anuradhapura</option>
          <option value="Polonnaruwa">Polonnaruwa</option>
          <option value="Matale">Matale</option>
          <option value="Nuwara Eliya">Nuwara Eliya</option>
          <option value="Kegalle">Kegalle</option>
          <option value="Ratnapura">Ratnapura</option>
          <option value="Trincomalee">Trincomalee</option>
          <option value="Batticaloa">Batticaloa</option>
          <option value="Ampara">Ampara</option>
          <option value="Badulla">Badulla</option>
          <option value="Monaragala">Monaragala</option>
          <option value="Hambantota">Hambantota</option>
          <option value="Matara">Matara</option>
          <option value="Galle">Galle</option>
          <option value="Jaffna">Jaffna</option>
          <option value="Kilinochchi">Kilinochchi</option>
          <option value="Mannar">Mannar</option>
          <option value="Mullaitivu">Mullaitivu</option>
          <option value="Vavuniya">Vavuniya</option>
          <option value="Kandy">Kandy</option>
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
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript">
    // Load google charts
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
      //test piechart
      var data_test = google.visualization.arrayToDataTable([
        ['Topic', 'Result'],
        ['Positive', 8],
        ['Negative', 2],
        ['Pending', 4]
      ]);
      var options_test1 = {
        'title': 'TEST RESULT',
        'width': 400,
        'height': 400
      };
      var chart_test = new google.visualization.PieChart(document.getElementById('piechart-test'));
      chart_test.draw(data_test, options_test1);
      //dose-1 piechart
      var data_dose_1 = google.visualization.arrayToDataTable([
        ['Vaccine Type', 'count'],
        ['Positive', 8],
        ['Negative', 2],
        ['Pending', 4]
      ]);
      var options_dose_1 = {
        'title': 'Dose 1',
        'width': 400,
        'height': 400
      };
      var chart_test = new google.visualization.PieChart(document.getElementById('piechart-vaccination-dose-1'));
      chart_test.draw(data_dose_1, options_dose_1);

      //dose-2 piechart
      var data_dose_1 = google.visualization.arrayToDataTable([
        ['Vaccine Type', 'count'],
        ['Positive', 8],
        ['Negative', 2],
        ['Pending', 4]
      ]);
      var options_dose_1 = {
        'title': 'Dose 1',
        'width': 400,
        'height': 400
      };
      var chart_test = new google.visualization.PieChart(document.getElementById('piechart-vaccination-dose-2'));
      chart_test.draw(data_dose_1, options_dose_1);
      //dose-3 piechart
      var data_dose_1 = google.visualization.arrayToDataTable([
        ['Vaccine Type', 'count'],
        ['Positive', 8],
        ['Negative', 2],
        ['Pending', 4]
      ]);
      var options_dose_1 = {
        'title': 'Dose 1',
        'width': 400,
        'height': 400
      };
      var chart_test = new google.visualization.PieChart(document.getElementById('piechart-vaccination-dose-3'));
      chart_test.draw(data_dose_1, options_dose_1);
    }
  </script>
</body>

</html>