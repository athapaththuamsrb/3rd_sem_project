<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="css/bootstrap-5.1.3-dist/css/bootstrap.min.css"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap"
      rel="stylesheet"
    />
    <script src="./css/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <title>Document</title>
    <style>
      /* .item1 {
        grid-area: nav;
      }
      .item2 {
        grid-area: header;
      }
      
      .item4 {
        grid-area: footer;
      }
      .grid-contener {
        display: grid;
        grid-template-areas: "nav" "header" "buttonSet" "footer";
      } */
      body {
        /* background-image: url("./image/Corona-Header.jpg"); */
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
      .item2 > div {
        font-size: 300%;
        font-family: "Oswald", sans-serif;
        color: brown;
        font-weight: bold;
        position: relative;
      }
    
      .txt{
        font-size: 200%;
        font-family: "Oswald", sans-serif;
        color: black;
        font-weight: bold;
        position: relative;
      }

      .item3 {
        margin-top: 30px;
      }

      .item4{
        height: 300px;
        width: 300px;
        margin: auto;
        margin-top: 60px;
        background-color: aqua;
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
                <!-- <li class="nav-item">
                  <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown link
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
                </li> -->
              </ul>
            </div>
          </div>
        </nav>
      </div>
      <div class="item2 d-flex justify-content-center">
        <div id="div1">View Results</div>
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
      <div class="item4">
        Result
      </div>
      
     
    </div>



    <script type="text/javascript">
      function submit1() {
        let id = document.getElementById("inputID").value;
    
        var xhr = new XMLHttpRequest();
        xhr.open("POST", document.URL, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("id=" + encodeURIComponent(id));
        console.log("id=" + encodeURIComponent(id))
        // xhr.onreadystatechange = function() {
        //   if (xhr.readyState == XMLHttpRequest.DONE) {
        //     let data = JSON.parse(xhr.responseText);
        //     console.log(data);
        //   }
        // }
      }
    </script>
  </body>
</html>
