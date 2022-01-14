function submitResult() {
  let token = document.getElementById("inputToken").value;
  let result = document.getElementById("result").value;
  
  if (!/^[a-z0-9]{6}$/.test(token)) {
    setModal(false, "Entered token is invalid");
    return false;
  }
  if (result!="Positive"&& result!="Negative") {
    setModal(false, "Entered result is invalid");
    return false;
  }

  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField("token", token);
  xhrBuilder.addField("result", result);
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
