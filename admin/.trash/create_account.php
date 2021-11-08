<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['type']) && $_POST['username'] && $_POST['password'] && $_POST['type']) {
		//TODO : call database function and check if success by return value.
		//if failed, resend this page with an error message (redirect to this page + $_SESSION['error_message']="cause of error")
		//if success, redirect to /admin/
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Request Application</title>
	<link rel="stylesheet" type="text/css" href="/styles/all.css">
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		* {
			margin: 0;
			padding: 0;
			color: red;
		}

		#application {
			padding: 10px;
		}

		#loginButton {
			width: 250px;
			background-color: blue;
		}

		body,
		html {
			margin-top: 10px;
			background: url("/image/Covid-19-Test-and-Vaccine.jpg") no-repeat center;
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
			font-family: sans-serif;
		}

		html {
			overflow-x: scroll;
			overflow-y: scroll;
		}

		#cover {
			background-color: rgb(0, 0, 0, 0.6);
			width: 800px;
			margin: auto;
			border-bottom-left-radius: 15px;
			border-bottom-right-radius: 15px;
		}

		#other {
			text-align: left;
			padding: 20px;
		}

		#field {
			width: 100%;
			height: 100px;
		}

		.field {
			margin-left: 100px;
			width: 200 px;
			font-size: 18px;
			font-weight: 700;
		}

		#intro {
			text-align: center;
		}

		.buttons {
			text-align: center;

		}

		#submitButton {
			background-color: rgb(225, 220, 220);
			display: inline-block;
			font-size: 20px;
			text-align: center;
			border-radius: 12px;
			border: 2px solid black;
			padding: 5px 15px;
			outline: none;
			cursor: pointer;
			transition: 0.25px;
		}

		#hideWord {
			visibility: hidden;
			/* Position the tooltip */
			position: absolute;
			z-index: 1;
			font-size: 50%;
			background-color: red;
			padding-left: 2px;
		}

		#iconBack #hideWord::after {
			content: " ";
			position: absolute;
			top: 50%;
			right: 100%;
			/* To the left of the tooltip */
			margin-top: -5px;
			border-width: 5px;
			border-style: solid;
			border-color: transparent red transparent transparent;
		}

		#iconBack:hover #hideWord {
			visibility: visible;
		}

		.topic {
			width: 800px;
			background-color: rgb(0, 0, 0, 0.6);
			margin: auto;
			color: white;
			padding: 10px 0px 10px 0px;
			text-align: center;
			border-radius: 15px 15px 0px 0px;
		}

		#index {
			position: relative;
			line-height: 40px;
			border-radius: 6px;
			padding: 0 37px;
			font-size: 16px;
			left: 400px;
			top: -20px;
		}

		#Department {
			position: relative;
			line-height: 40px;
			border-radius: 6px;
			padding: 0 13px;
			font-size: 16px;
			left: 400px;
			top: -20px;
			margin-bottom: 15px;
			border: 2px solid black;
		}

		#userName,
		#email,
		#ContactNo,
		#password,
		#confirmPW,
		#type,
		#Index,
		#fullName {
			position: relative;
			line-height: 40px;
			border-radius: 6px;
			padding: 0 37px;
			font-size: 16px;
			left: 400px;
			top: -37px;
		}

		#invalid {
			width: 72%;
			height: 40px;
			position: relative;
			text-align: center;
			left: 13%;
		}
	</style>
</head>

<body>
	<div class="topic">
		<h1>Creat account</h1>
	</div>
	<div id="cover">
		<form id="application" method="POST">

			<div id="field">
				<br>
				<label for="userName">
					<h2 class="field">Username</h2>
				</label>
				<input placeholder="UserName" type="text" id="userName" name="UserName" required>
			</div>

			<div class="textbox">
				<label for="Type">
					<h2 class="field">Account Type</h2>
				</label>
				<div id="type">
					<label for="student">Admin</label>
					<input type="radio" name="type" id="admin" value="admin" checked>
					<br>
					<label for="staff">Testing center</label>
					<input type="radio" name="type" id="Testing_center" value="testing">
					<br>
					<label for="staff">Vaccination center</label>
					<input type="radio" name="type" id="Vaccination_center" value="vaccination">
				</div>
			</div>

			<label for="Email">
				<h2 class="field">Email Address</h2>
			</label>
			<input placeholder="Email Address" type="email" id="email" name="email" required>

			<label for="ContactNo">
				<h2 class="field">Contact Number</h2>
			</label>
			<input placeholder="0123456789" type="tel" id="ContactNo" pattern="[0-9]{10}" name="telephone" required>


			<label for="password">
				<h2 class="field">Password</h2>
			</label>
			<input placeholder="Password" type="password" id="password" name="password" required>

			<label for="confirmPW">
				<h2 class="field">Confirm Password</h2>
			</label>
			<input placeholder="Confirm Password" type="password" id="confirmPW" required>


			<div class="buttons">
				<button id="submitButton" type="submit" name="submit" onclick="return validate() && validateUserName() && isRequirment()">Submit</button>
			</div>
			<p id="other"><a href="./">Do you need to go back?</a></p>
		</form>

		<script type="text/javascript">
			document.getElementById("type").addEventListener("change", dothis);

			function dothis() {
				var radios = document.getElementsByName("typ");
				var selected = Array.from(radios).find(radio => radio.checked);
				var doThis = document.getElementById("hide").style.display
				if (selected.value == "staff") {
					document.getElementById("hide").style.display = "none";
					document.getElementById("department").required = false;
					document.getElementById("Index").required = false;
				} else {
					document.getElementById("hide").style.display = "block";
					document.getElementById("department").required = true;
					document.getElementById("Index").required = true;
				}
			}

			function validateUserName() {
				var userName = document.getElementById("userName");
				var userName_patton = /^[a-zA-Z0-9_]{5,20}$/;
				return userName.value.length >= 10 && userName.value.match(userName_patton) ? true : false;
			}

			function validate() {
				var password = document.getElementById("password").value;
				var confirmPassword = document.getElementById("confirmPW").value;
				if (password != confirmPassword) {
					alert("Passwords do not match.");
					return false;
				}
				return true;
			}

			function isRequirment() {
				var password = document.getElementById("password");
				var password_patton = /^\S*(?=\S{8,15})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/;
				return password.value.match(password_patton) ? true : false;
			}
		</script>
</body>

</html>