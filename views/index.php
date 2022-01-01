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
		}

		#actions {
			margin-top: 100px;
		}

		.btn:hover {
			-ms-transform: scale(1.2);
			/* IE 9 */
			-webkit-transform: scale(1.2);
			/* Safari 3-8 */
			transform: scale(1.2);
			background-color: blue;
		}

		#vaccine_appointment,
		#vaccination_certificat,
		#vaccination_status {
			padding: 20px 30px;
			font-size: 25px;
			font-weight: 500;
		}

		#title {
			margin-top: 30px;
			font-size: 50px;
			font-weight: 600;
			color: white;
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
		}

		.dropdown-content {
			display: none;
			position: absolute;
			background-color: #f1f1f1;
			min-width: 160px;
			box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
			z-index: 1;
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

		dropdown-content>a {
			width: 500%;
		}
	</style>
</head>
<div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">

	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container-fluid">
				<h1 class="navbar-brand">Public</h1>
				<div class="dropdown">
					<button class="dropbtn">Login
						<i class="fa fa-caret-down"></i>
					</button>
					<div class="dropdown-content">
						<a href="/vaccination/">Vaccination&nbsp;center&nbsp;</a>
						<a href="/testing/">Testing&nbsp;center&nbsp;</a>
						<a href="/admin/">Admin&nbsp;</a>
					</div>
				</div>
			</div>
		</nav>

		<div class="d-flex justify-content-center" id="title">
			Dashboard
		</div>
		<div class="d-flex justify-content-center" id="actions">
			<a href="/vaccineAppointment.php"><button type="button" class="btn btn-primary" id="vaccine_appointment">Vaccine Appointment</button></a>
		</div>
		<div class="d-flex justify-content-center" id="actions">
			<a href="/vaccinationStatus.php"><button type="button" class="btn btn-primary" id="vaccination_status">Vaccination Status</button></a>
		</div>
		<div class="d-flex justify-content-center" id="actions">
			<a href="/vaccineCertificate.php"><button type="button" class="btn btn-primary" id="vaccination_certificat">Vaccination certificate</button></a>
		</div>
	</body>
</div>

</html>