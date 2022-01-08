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
<link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
<!--link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap"
    rel="stylesheet"
  /-->
<script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
<style>
  * {
    box-sizing: border-box;
  }

  body {
    background: url("/image/Covid-19-Test-and-Vaccine.jpg") no-repeat center center fixed;
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
    border: black solid 2px;
  }

  /* Mark input boxes that gets an error on validation: */
  input.invalid {
    background-color: #ffdddd;
  }

  /* Hide all steps by default: */
  .tab {
    display: none;
  }

  #regForm {
    border: black solid 3px;
    border-radius: 10%;
    background-color: rgba(255, 255, 255, 0.9);
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
    opacity: 0.7;
  }

  .step.active {
    opacity: 1;
  }

  /* Mark the steps that are finished and valid: */
  .step.finish {
    background-color: #04aa6d;
  }

  .hide {
    display: none;
  }

  .grid-container {
    display: grid;
    grid-template-columns: auto auto;
  }

  .grid-item {
    font-size: 15pt;
    text-align: center;
    width: 40%;
  }

  input {
    width: 100%;
    padding-right: 30%;
  }

  label {
    float: left;
    padding-left: 8%;
  }
</style>

<body>
  <form id="regForm" method="POST">
    <h1>Create account:</h1>
    <!-- One "tab" for each step in the form: -->
    <div class="tab">
      <h3>Admin type:</h3>
      <br />
      <div class="grid-container">
        <div class="grid-item">
          <label for="Testing_center">Testing center:</label>
        </div>
        <div class="grid-item">
          <input type="radio" class="radio_bt" name="type" id="Testing_center" value="testing" oninput="this.className = ''" />
        </div>
        <div class="grid-item">
          <label for="Vaccination_center">Vaccination center</label>
        </div>
        <div class="grid-item">
          <input type="radio" class="radio_bt" name="type" id="Vaccination_center" value="vaccination" oninput="this.className = ''" />
        </div>
        <div class="grid-item">
          <label for="Administrator">Administrator</label>
        </div>
        <div class="grid-item">
          <input type="radio" class="radio_bt" name="type" id="Administrator" value="admin" oninput="this.className = ''" checked />
        </div>
      </div>
    </div>
    <div class="tab">
      <div id="address">
        <label for="districts">Districts:</label>
        <select name="district" id="districts" oninput="this.className = ''">
          <option value="Colombo">Colombo</option>
          <option value="Gampaha">Gampaha</option>
          <option value="Kalutara">Kalutara</option>
          <option value="Galle">Galle</option>
          <option value="Matara">Matara</option>
          <option value="Hambantota">Hambantota</option>
          <option value="Kandy">Kandy</option>
          <option value="Matale">Matale</option>
          <option value="Nuwara Eliya">Nuwara Eliya</option>
          <option value="Anuradhapura">Anuradhapura</option>
          <option value="Polonnaruwa">Polonnaruwa</option>
          <option value="Puttalam">Puttalam</option>
          <option value="Kurunegala">Kurunegala</option>
          <option value="Kegalle">Kegalle</option>
          <option value="Ratnapura">Ratnapura</option>
          <option value="Trincomalee">Trincomalee</option>
          <option value="Batticaloa">Batticaloa</option>
          <option value="Ampara">Ampara</option>
          <option value="Badulla">Badulla</option>
          <option value="Monaragala">Monaragala</option>
          <option value="Jaffna">Jaffna</option>
          <option value="Kilinochchi">Kilinochchi</option>
          <option value="Mannar">Mannar</option>
          <option value="Mullaitivu">Mullaitivu</option>
          <option value="Vavuniya">Vavuniya</option>
        </select><br />
        <div>
          Location:
          <p>
            <input id="place" placeholder="location" oninput="this.className = ''" name="place" onkeypress="keypress(event, 0);" />
          </p>
        </div>
      </div>
    </div>
    <div class="tab">
      <div>
        Email:
        <p>
          <input placeholder="Email" type="email" id="email" oninput="this.className = ''" name="email" onkeypress="keypress(event, 1);" />
        </p>
      </div>
    </div>
    <div class="tab">
      <div>
        User Name:
        <p>
          <input id="username" placeholder="User Name" oninput="this.className = ''" name="username" onkeypress="keypress(event, 2);" />
        </p>
      </div>
    </div>

    <div class="tab">
      password:
      <p>
        <input id="password" placeholder="Password" id="password" type="password" oninput="this.className = ''" name="password" onkeypress="keypress(event, 3);" />
      </p>
      <p>
        <input placeholder="conform password" id="conPassword" type="password" oninput="this.className = ''" onkeypress="keypress(event, 4);" />
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
      <span class="step"></span>
      <span class="step"></span>
    </div>
  </form>

  <script src="/scripts/common.js"></script>
  <script src="/scripts/admin/createAccount.js"></script>
</body>

</html>