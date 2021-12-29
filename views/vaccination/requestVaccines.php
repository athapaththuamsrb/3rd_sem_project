<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<style>
	html,body{
		padding: 0;
		margin: 0;
	}
.centerBox{
	text-align: center;
	position: absolute;
	top: 30%;
	left: 25%;
	width: 50%;
	background-color: antiquewhite;
	border: 2px solid black;
	border-top-left-radius: 40%;
	border-bottom-right-radius: 40%;
}
.centerBox:hover{
	border: 4px solid black;
}
input:hover,select:hover{
	border: 2px solid blue;
}
button{
	background-color: green;
	color: white;
	border: 2px solid black;
	border-radius: 5%;
	width: 40%;
}
button:hover{
	-ms-transform: scale(1.2); /* IE 9 */
	-webkit-transform: scale(1.2); /* Safari 3-8 */
  transform: scale(1.2);
}
nav{
	background-color:rgb(2, 2, 59);
	height: 10vh;
	width: 100%;
	padding: 0;
	margin: 0;
}
#type{
	width: 30%;
	font-size: medium;
}
#type,input{
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
	<nav></nav>
	<fieldset class="centerBox">
		<legend ><h2>Requesting Vaccination</h2></legend>
		<div class="grid-container">
<div class="grid-item">
	<label for="type">Type</label>&nbsp;
</div>
<div  class="grid-item">	
	<select name="type" id="type" readonly="readonly">
	<option value="Pfizer" >Pfizer</option>
	<option value="Aztraseneca" >Aztraseneca</option>
	<option value="Sinopharm">Sinopharm</option>
	<option value="Moderna">Moderna</option>
	</select>
</div>
<br>
<div  class="grid-item">
	<label for="dose">Dose</label>
</div>
<div  class="grid-item">	
	<input type="number" name="dose" id="dose" min=1 max=2>
</div>
<br>
<div class="grid-item">
	<label for="amount">Amount</label>&nbsp;
</div>
<div  class="grid-item">
	<input type="number" id="amount" name="amount" placeholder="amount" min=0>
</div>
<br>
</div>
<button>Request</button>
	</fieldset>

</body>
</html>