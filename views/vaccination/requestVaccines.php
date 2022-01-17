<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="/styles/all.css" />
	<link rel="stylesheet" href="/styles/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
	<script src="/styles/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
	<title>Request Vaccination</title>
</head>
<style>
	html,
	body {
		padding: 0;
		margin: 0;
	}

	.centerBox {
		text-align: center;
		position: absolute;
		top: 30%;
		left: 25%;
		width: 50%;
		background-color: antiquewhite;
		border: 2px solid black;
		border-top-left-radius: 15px;
		border-bottom-right-radius: 15px;
	}

	.centerBox:hover {
		border: 4px solid black;
	}

	input:hover,
	select:hover {
		border: 2px solid blue;
	}

	.centerBox button {
		background-color: green;
		color: white;
		border: 2px solid black;
		border-radius: 15px;
		width: 40%;
		margin: 10px;
	}

	button:hover {
		-ms-transform: scale(1.2);
		/* IE 9 */
		-webkit-transform: scale(1.2);
		/* Safari 3-8 */
		transform: scale(1.2);
	}

	#type {
		width: 30%;
		font-size: medium;
	}

	#type,
	input,
	select {
		width: 90%;
		font-size: 13pt;
		padding-left: 4%;
	}

	.grid-container {
		display: grid;
		grid-template-columns: auto auto auto;
		padding: 10px;
	}

	.grid-item {
		padding-left: 50%;
		padding-bottom: 5%;
		font-size: 15pt;
	}

	label {
		text-align: left;
		float: left;
	}

	.container-fluid {
		padding-left: 1.5%;
	}
</style>

<body>
	<?php
	@include('navbar.php') ?>
	<br>
	<fieldset class="centerBox">
		<legend>
			<h2>Requesting Vaccination</h2>
		</legend>
		<div class="grid-container">
			<div class="grid-item">
				<label for="type">Type:</label>&nbsp;
			</div>
			<div class="grid-item">
				<select name="type" id="type" readonly="readonly">
					<?php
					require_once($_SERVER['DOCUMENT_ROOT'] . '/.utils/global.php');
					foreach (VACCINES as $type) {
					?>
						<option value="<?php echo $type; ?>"><?php echo $type; ?></option>
					<?php
					} ?>
				</select>
			</div>
			<br>
			<div class="grid-item">
				<label for="dose">Dose:</label>
			</div>
			<div class="grid-item">
				<input type="number" name="dose" id="dose" min=1 placeholder="Dose">
			</div>
			<br>
			<div class="grid-item">
				<label for="amount">Amount:</label>&nbsp;
			</div>
			<div class="grid-item">
				<input type="number" id="amount" name="amount" placeholder="Amount" min=0>
			</div>
		</div>
		</div>
		<button onclick="requestSubmit()" class="btn btn-success">Request</button>
		<br>
	</fieldset>

	<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/views/modal.php');
	addModal('Request Vaccines');
	?>

	<script src="/scripts/common.js"></script>
	<script src="/scripts/vaccination/requestVaccines.js"></script>
</body>

</html>