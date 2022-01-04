function updateStock() {
  let type = document.getElementById("type").value;
  let dose = document.getElementById("dose").value;
  let amount = document.getElementById("amount").value;
  amount = parseInt(amount);
  dose = parseInt(dose);
  if (!type || !dose || !amount || dose <= 0 || amount <= 0) {
    alert("Entered data is invalid");
    return false;
  }

  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('type', type);
  xhrBuilder.addField('dose', dose);
  xhrBuilder.addField('amount', amount);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
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