<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccine Appoinment</title>
</head>

<body>
    <form>
        <label for="district">District:</label><br>
        <input type="text" id="district" name="district" value=""><br>

        <input type="button" value="Submit" onclick="submit1()">
    </form>
    <script type="text/javascript">
        function submit1() {
      let district = document.getElementById("district").value;

      var xhr = new XMLHttpRequest();
      xhr.open("POST", document.URL, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send("district=" + encodeURIComponent(district));
    //   xhr.onreadystatechange = function() {
    //     if (xhr.readyState == XMLHttpRequest.DONE) {
    //       let data = JSON.parse(xhr.responseText);
          
    //     }
    //   }
    }
    </script>
</body>

</html>