function getDateStr() {
  let d = new Date();
  d.setDate(d.getDate() + 1);
  let month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();

  if (month.length < 2) month = "0" + month;
  if (day.length < 2) day = "0" + day;

  return [year, month, day].join("-");
}

document.getElementById("date").setAttribute("min", getDateStr());

function submitStock() {
  let date = document.getElementById("date").value;
  let type = document.getElementById("type").value;
  let amount = document.getElementById("amount").value;
  let onlineAmount = document.getElementById("onlineAmount").value;

  if (!/^[0-9]+$/.test(amount)) {
    setModal(false, "Entered amount is invalid");
    return false;
  }
  if (!/^[0-9]+$/.test(onlineAmount)) {
    setModal(false, "Entered online amount is invalid");
    return false;
  }
  amount = parseInt(amount);
  onlineAmount = parseInt(onlineAmount);
  if (!date || !type || !amount || !onlineAmount || amount <= 0 || onlineAmount < 0 || onlineAmount > amount) {
    setModal(false, "Entered data is invalid");
    return false;
  }

  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField("date", date);
  xhrBuilder.addField("type", type);
  xhrBuilder.addField("amount", amount);
  xhrBuilder.addField("onlineAmount", onlineAmount);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr.responseText);
        let msg = data["success"] === true ? "Success!" : "Failed!";
        setModal(data["success"], msg);
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
