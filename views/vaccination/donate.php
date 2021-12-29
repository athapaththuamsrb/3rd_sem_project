<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate vaccines</title>
</head>

<body>
    <form method="POST">
        <label for="place">Place</label>
        <input placeholder="Place" type="text" id="place" name="place" value="<?php echo $_GET['place']; ?>" required />
        <label for="type">Type</label>
        <select name="type" id="type" required>
            <option value="Pfizer" <?php if ($_GET['type'] === 'Pfizer') echo 'selected' ?>>Pfizer</option>
            <option value="Aztraseneca" <?php if ($_GET['type'] === 'Aztraseneca') echo 'selected' ?>>Aztraseneca</option>
            <option value="Sinopharm" <?php if ($_GET['type'] === 'Sinopharm') echo 'selected' ?>>Sinopharm</option>
            <option value="Moderna" <?php if ($_GET['type'] === 'Moderna') echo 'selected' ?>>Moderna</option>
        </select>

        <label for="dose">Dose</label>
        <input type="number" name="dose" id="dose" min=1 required>

        <label for="amount">Amount</label>
        <input type="number" id="amount" name="amount" value="<?php echo $_GET['amount']; ?>" placeholder="amount" min=0 required>

        <button type="button" onclick="donate()">Donate</button>
    </form>

    <script src="/scripts/common.js"></script>
    <script type="text/javascript">
        function donate() {
            let type = document.getElementById("type").value;
            let place = document.getElementById("place").value;
            let dose = document.getElementById("dose").value;
            let amount = document.getElementById("amount").value;
            amount = parseInt(amount);
            dose = parseInt(dose);
            if (!type|| !place || !dose || !amount || dose <= 0 || amount <= 0) {
                alert("Entered data is invalid");
                return false;
            }

            let xhrBuilder = new XHRBuilder();
            xhrBuilder.addField('type', type);
            xhrBuilder.addField('place', place);
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
                        alert(data["success"] === true ? "Success" : "Failed!");
                        if (data["success"]) {
                            list = document.getElementsByTagName("input");
                            for (let index = 0; index < list.length; index++) {
                                list[index].value = "";
                            }
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