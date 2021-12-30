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
		border-top-left-radius: 10%;
		border-bottom-right-radius: 10%;
	}

	.centerBox:hover {
		border: 4px solid black;
	}

	input:hover,
	select:hover {
		border: 2px solid blue;
	}

	button {
		background-color: green;
		color: white;
		border: 2px solid black;
		border-radius: 5%;
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

	nav {
		background-color: rgb(2, 2, 59);
		height: 10vh;
		width: 100%;
		padding: 0;
		margin: 0;
	}

	#type {
		width: 30%;
		font-size: medium;
	}

	#type,
	input {
		width: 90%;
	}

	.grid-container {
		display: grid;
		grid-template-columns: auto auto auto;
		padding: 10px;
	}

	.grid-item {
		padding: 20px;
		font-size: 30px;
		text-align: center;
	}
</style>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">Vaccination Center</a>
		</div>
	</nav>
	<fieldset class="centerBox">
		<legend>
			<h2>Requesting Vaccination</h2>
		</legend>
		<div class="grid-container">
			<div class="grid-item">
				<label for="type">Type</label>&nbsp;
			</div>
			<div class="grid-item">
				<select name="type" id="type" readonly="readonly">
					<option value="Pfizer">Pfizer</option>
					<option value="Aztraseneca">Aztraseneca</option>
					<option value="Sinopharm">Sinopharm</option>
					<option value="Moderna">Moderna</option>
				</select>
			</div>
			<br>
			<div class="grid-item">
				<label for="dose">Dose</label>
			</div>
			<div class="grid-item">
				<input type="number" name="dose" id="dose" min=1>
			</div>
			<br>
			<div class="grid-item">
				<label for="amount">Amount</label>&nbsp;
			</div>
			<div class="grid-item">
				<input type="number" id="amount" name="amount" placeholder="amount" min=0>
			</div>
		</div>
		</div>
		<button onclick="requestSubmit()">Request</button>
		<br>
	</fieldset>

	<script src="/scripts/common.js"></script>
	<script type="text/javascript">
		function requestSubmit() {
			let type = document.getElementById("type").value;
			let dose = document.getElementById("dose").value;
			let amount = document.getElementById("amount").value;
			if (!type || !dose || !amount || dose <= 0 || amount <= 0) {
				alert("Entered data is invalid");
				return false;
			}

			let xhrBuilder = new XHRBuilder();
			xhrBuilder.addField('type', type);
			xhrBuilder.addField('dose', dose);
			xhrBuilder.addField('amount', amount);
			var xhr = new XMLHttpRequest();
			xhr.open("POST", document.URL, true);
			xhr.setRequestHeader(
				"Content-Type",
				"application/x-www-form-urlencoded"
			);
			xhr.send(xhrBuilder.build());
			xhr.onreadystatechange = function() {
				if (xhr.readyState == XMLHttpRequest.DONE) {
					try {
						let data = JSON.parse(xhr.responseText);
						$count = data['count'];
						if ($count) {
							alert('Request emails were sent');
							list = document.getElementsByTagName("input");
							for (let index = 0; index < list.length; index++) {
								list[index].value = "";
							}
						} else {
							alert('No emails were sent');
						}
					} catch (error) {
						alert("Error occured");
					}
				}
			};
		}
	</script>
</body>

</html>