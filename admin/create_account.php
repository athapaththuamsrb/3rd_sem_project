<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['password']) || !$_POST['username'] || !$_POST['password'] || !$_POST['type']) {
    header('Location: ' . $_SERVER['REQUEST_URI']);
    die();
  }
  require_once('../.utils/dbcon.php');
  $conn = DatabaseConn::get_conn();
  if (!$conn || !$conn->create_user($_POST['username'], $_POST['password'], $_POST['type'])){
    header('Location: ' . $_SERVER['REQUEST_URI']);
    die();
  }
  header('Location: /admin/');
  die();
}
?>
<!DOCTYPE html>
<html>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!--link
    href="https://fonts.googleapis.com/css?family=Raleway"
    rel="stylesheet"
  /-->
  <link rel="stylesheet" type="text/css" href="/styles/all.css" />
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link
    rel="stylesheet"
    href="/css/bootstrap-5.1.3-dist/css/bootstrap.min.css"
  />
  <!--link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap"
    rel="stylesheet"
  /-->
  <script src="/css/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      background: url("/image/Covid-19-Test-and-Vaccine.jpg") no-repeat center
        center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      font-family: sans-serif;
    }

    #regForm {
      background-color: #ffffff;
      margin: 100px auto;
      font-family: Raleway;
      padding: 40px;
      width: 70%;
      min-width: 300px;
    }

    h1 {
      text-align: center;
    }

    input {
      padding: 10px;
      width: 100%;
      font-size: 17px;
      font-family: Raleway;
      border: 1px solid #aaaaaa;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
      background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
      display: none;
    }

    button {
      background-color: #04aa6d;
      color: #ffffff;
      border: none;
      padding: 10px 20px;
      font-size: 17px;
      font-family: Raleway;
      cursor: pointer;
    }

    button:hover {
      opacity: 0.8;
    }

    #prevBtn {
      background-color: #bbbbbb;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
      height: 15px;
      width: 15px;
      margin: 0 2px;
      background-color: #bbbbbb;
      border: none;
      border-radius: 50%;
      display: inline-block;
      opacity: 0.5;
    }

    .step.active {
      opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
      background-color: #04aa6d;
    }

    .hide{
      display: none;
    }
  </style>
  <body>
    <form id="regForm" method="POST">
      <h1>Creat account:</h1>
      <!-- One "tab" for each step in the form: -->
      <div class="tab">
        <h3>Admin type:</h3>
        <br />
        <div>
          Testing center:
          <input
            type="radio"
            name="type"
            id="Testing_center"
            value="testing"
            oninput="this.className = ''"
          />
        </div>
        <div>
          Vaccination center
          <input
            type="radio"
            name="type"
            id="Vaccination_center"
            value="vaccination"
            oninput="this.className = ''"
          />
        </div>
        <div>
          Administrator
          <input
            type="radio"
            name="type"
            id="Administrator"
            value="admin"
            oninput="this.className = ''"
          />
        </div>
      </div>

      <div class="tab">
        <div>
          User Name:
          <p>
            <input
              placeholder="User Name"
              oninput="this.className = ''"
              name="username"
            />
          </p>
        </div>
        <div id="location" class="location">
          Location:
          <p>
            <input
              placeholder="User Name"
              oninput="this.className = ''"
              name="place"
            />
          </p>
        </div>
        
      </div>

      <div class="tab">
        password:
        <p>
          <input
            placeholder="Password"
            oninput="this.className = ''"
            name="password"
          />
        </p>
        <p>
          <input
            placeholder="conform password"
            oninput="this.className = ''"
            name="conform_passsword"
          />
        </p>
      </div>
      <div style="overflow: auto">
        <div style="float: right">
          <button type="button" id="prevBtn" onclick="nextPrev(-1)">
            Previous
          </button>
          <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
      </div>
      <!-- Circles which indicates the steps of the form: -->
      <div style="text-align: center; margin-top: 40px">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
      </div>
    </form>

    <script>
      var currentTab = 0; // Current tab is set to be the first tab (0)
      showTab(currentTab); // Display the current tab

      function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
          document.getElementById("prevBtn").style.display = "none";
        } else {
          document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == x.length - 1) {
          document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
          document.getElementById("nextBtn").innerHTML = "Next";
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n);
      }

      function nextPrev(n) {
        // This function will figure out which tab to display
       
        var x = document.getElementsByClassName("tab");

        //location input only for vaccine accounts
        if(n==1){
          // console.log(document.getElementById("Vaccination_center").checked);
          if (!document.getElementById("Vaccination_center").checked) {
            document.getElementById('location').classList.add("hide")
          }else{
            document.getElementById('location').classList.remove("hide")
          }
        }

        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()){
          
          return false;

        } 
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
          // ... the form gets submitted:
          document.getElementById("regForm").submit();
          return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
      }

      function validateForm() {
        // This function deals with validation of the form fields
        var x,
          y,
          i,
          valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
          // If a field is empty...
          if (y[i].value == "") {
            // add an "invalid" class to the field:
            y[i].className += " invalid";
            // and set the current valid status to false
            valid = false;
          }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
          document.getElementsByClassName("step")[currentTab].className +=
            " finish";
        }
        return valid; // return the valid status
      }

      function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i,
          x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
          x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
      }

     
    </script>
  </body>
</html>
