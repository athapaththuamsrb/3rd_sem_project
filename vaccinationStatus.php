<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['id']) || !$_POST['id']) {
    die();
  }
  $id = $_POST['id'];
  require_once('.utils/dbcon.php');
  $conn = DatabaseConn::get_conn();
  if ($conn) {
    $data = $conn->get_vaccination_records($id, null);
    if (isset($data['doses']) && is_array($data['doses'])) {
      $data = $data['doses'];
      foreach ($data as $key => $dose) {
        unset($data[$key]['place']);
      }
    } else {
      $data = null;
    }
  } else {
    $data = null;
  }
  echo json_encode($data);
  die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
  <!--link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet" /-->
  <script src="/css/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
  <title>Document</title>
  <style>
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

    body {
      /* background-image: url("/image/Corona-Header.jpg"); */
      /* background-color: blue; */
      height: 60vh;
      padding: 0;
      margin: 0;

      background-position: right;
      background-repeat: no-repeat;
      background-size: 900px;
      z-index: -1;
      overflow: hidden;
    }

    .item2>div {
      font-size: 300%;
      font-family: "Oswald", sans-serif;
      color: brown;
      font-weight: bold;
      position: relative;
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
      /* height: 300px; */
      width: 300px;
      margin: auto;
      margin-top: 60px;

    }
  </style>
</head>

<body>
  <div class="grid-contener">
    <div class="item1">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Navbar</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <div class="item2 d-flex justify-content-center">
      <div id="div1">View Vaccination Status</div>
    </div>

    <div class="item3 d-flex justify-content-center">
      <form>
        <div class="row g-3 align-items-center">
          <div class="col-auto">
            <label for="inputID" class="form-label txt">Enter ID</label>
          </div>
          <div class="col-auto">
            <input type="text" class="form-control" id="inputID" aria-describedby="emailHelp">
          </div>
          <div class="col-auto">
            <button type="button" class="btn btn-primary" onclick="submit1()">Submit</button>
          </div>
        </div>

      </form>
    </div>
    <div id="results" class="item4">
      <table id="resultTable">
      </table>
    </div>


  </div>



  <script type="text/javascript">
    function submit1() {
      let id = document.getElementById("inputID").value;

      var xhr = new XMLHttpRequest();
      xhr.open("POST", document.URL, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send("id=" + encodeURIComponent(id));
      xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
          let data = JSON.parse(xhr.responseText);
          if (data != null && Array.isArray(data)) {
            let output = document.getElementById("resultTable");
            var tableContent = "<tr><th>Type</th><th>Date</th></tr>"
            for (index = 0; index < data.length; index++) {
              tableContent += "<tr><td>" + data[index]["type"] + "</td>" +
                "<td>" + data[index]["date"] + "</td></tr>";
            }
            output.innerHTML = tableContent;
          }else{
            let output = document.getElementById("results");
            output.innerHTML = '<h2>Error occured!</h3><p>Couldn\'t load vaccination status.</p>'
          }
        }
      };
      // xhr.onreadystatechange = function() {
      //   if (xhr.readyState == XMLHttpRequest.DONE) {
      //     let data = JSON.parse(xhr.responseText);
      //     console.log(data);

      // var data = [{
      //     type: 'Pfizer',
      //     date: '02/11/2021',
      //     place: 'colombo'
      //   },
      //   {
      //     type: 'Astrsasenica',
      //     date: '03/11/2021',
      //     place: 'homagama'
      //   },
      //   {
      //     type: 'Pfizer',
      //     date: '10/11/2021',
      //     place: 'colombo'
      //   },
      //   {
      //     type: 'Astrsasenica',
      //     date: '30/11/2021',
      //     place: 'homagama'
      //   }
      // ]

      //   }
      // }
    }
  </script>
</body>

</html>