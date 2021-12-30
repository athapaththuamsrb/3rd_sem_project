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
            <button type="button" class="btn btn-primary" onclick="getStatus()">Submit</button>
          </div>
        </div>

      </form>
    </div>
    <div id="results" class="item4">
    </div>
  </div>

  <script type="text/javascript" src="/scripts/common.js"></script>
  <script type="text/javascript" src="/scripts/vaccinationStatus.js"></script>
</body>
</html>