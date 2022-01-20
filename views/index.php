<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard</title>
	<link rel="stylesheet" type="text/css" href="/styles/all.css" />
	<link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
	<script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
	<style>
		body {
			background-image: url("/image/ad1.jpg");
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-position: center;
			background-color: rgb(190, 190, 190);
			z-index: 0;
		}

		#actions {
			margin-top: 5%;
		}

		.btn:hover {
			-ms-transform: scale(1.2);
			/* IE 9 */
			-webkit-transform: scale(1.2);
			/* Safari 3-8 */
			transform: scale(1.2);
			background-color: blue;
		}

		.btn-font {
			font-size: 14pt;
		}

		#title {
			margin-top: 30px;
			font-size: 50px;
			font-weight: 600;
			color: white;
		}

		.btn {
			width: 120%;
			padding: 5%;
		}

		.mask {
			height: auto;
		}

		.dropbtn {
			background-color: #04AA6D;
			color: white;
			padding: 16px;
			font-size: 16px;
			border: none;
		}

		.dropdown {
			position: relative;
			display: inline-block;
			margin-right: 1%;
		}

		.dropdown-content {
			display: none;
			position: absolute;
			background-color: #f1f1f1;
			min-width: 160px;
			box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
			z-index: 2;
			right: 0;
		}

		.dropdown-content a {
			color: black;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
		}

		.dropdown-content a:hover {
			background-color: #ddd;
		}

		.dropdown:hover .dropdown-content {
			display: block;
		}

		.dropdown:hover .dropbtn {
			background-color: #3e8e41;
		}

		.dropdown-content>a {
			width: 102%;
		}

		h2 {
			text-align: center;
			padding-right: 3%;
		}

		nav {
			padding: 5px 0px 5px 0px;
			height: 80px;
			width: 100%;
		}

		.container-fluid {
			padding-left: 1.5%;
		}

		#vaccinationInfo,
		#testingInfo {
			display: none;
		}

		.grid-container {
			display: grid;
			grid-template-columns: auto auto auto;
			margin-bottom: 5%;
		}

		.grid-item {
			width: 100%;
			height: 150%;
			border: 2px solid black;
			background-color: gray;
			color: white;
			font-size: 20pt;
		}

		.btn-c:hover {
			-ms-transform: scale(1.05);
			/* IE 9 */
			-webkit-transform: scale(1.05);
			/* Safari 3-8 */
			transform: scale(1.05);
			background-color: #525252;
			color: white;
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<h1 class="navbar-brand"><img src="/image/icon-public.gif" height="48px">&nbsp; Public</h1>
			<div class="dropdown">
				<button class="dropbtn">Login&nbsp;
					<i class="fa fa-caret-down"></i>
				</button>
				<div class="dropdown-content">
					<a href="/vaccination/">Vaccination center</a>
					<a href="/testing/">Testing center</a>
					<a href="/admin/">Admin</a>
				</div>
			</div>
		</div>
	</nav>
	<br>
	<h2>Dashboard</h2>
	<div class="container">
		<div id="main" class="grid-container">
			<div>
				<button type="button" class="grid-item btn-c" onclick="showVaccinationInfo()">Vaccination</button>
			</div>
			<div>
				<button type="button" class="grid-item btn-c" onclick="showTestingInfo()">Testing</button>
			</div>
			<div>
				<a href="/statistics.php"><button type="button" id="statistics" class="grid-item btn-c" onclick="hideOthers()">Statistics</button></a>
			</div>
		</div>







		<div id="vaccinationInfo">
			<div class="row">
				<div class="col-3" id="actions">
					<a href="/vaccineAppointment.php"><button type="button" class="btn btn-primary btn-font" id="vaccine_appointment">Vaccine Appointment</button></a>
				</div>
				<div class="col-1"></div>
				<div class="col-3" id="actions">
					<a href="/vaccinationStatus.php"><button type="button" class="btn btn-primary btn-font" id="vaccination_status">Vaccination Status</button></a>
				</div>
				<div class="col-1"></div>
				<div class="col-3" id="actions">
					<a href="/vaccineCertificate.php"><button type="button" class="btn btn-primary btn-font" id="vaccination_certificate">Vaccination Certificate</button></a>
				</div>
			</div>
			<div class="row">
				<div class="col-4"></div>
				<div class="col-3" id="actions">
					<a href="/vaccineAvailability.php"><button type="button" class="btn btn-primary btn-font" id="vaccine_availability">Vaccine Availability</button></a>
				</div>
				<div class="col-4"></div>
			</div>
		</div>


		<div id="testingInfo">
			<div class="row">
				<div class="col-3" id="actions">
					<a href="/testingAppointment.php"><button type="button" class="btn btn-primary btn-font" id="testing_appointment">Testing Appointment</button></a>
				</div>
				<div class="col-1"></div>
				<div class="col-3" id="actions">
					<a href="/testingAvailability.php"><button type="button" class="btn btn-primary btn-font" id="testing_availability">Testing Availability</button></a>
				</div>
				<div class="col-1"></div>
				<div class="col-3" id="actions">
					<a href="/testResults.php"><button type="button" class="btn btn-primary btn-font" id="test_results">Test Results</button></a>
				</div>
			</div>
		</div>


	</div>
	<br><br>
	<script src="/scripts/index.js"></script>
</body>

</html>