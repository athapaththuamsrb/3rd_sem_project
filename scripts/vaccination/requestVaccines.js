function requestSubmit() {
  let type = document.getElementById("type").value;
  let dose = document.getElementById("dose").value;
  let amount = document.getElementById("amount").value;
  if(!/^[1-3]$/.test(dose)||!/^[0-9]+$/.test(amount)){
    alert("Entered data is invalid");
    return false;
  }
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
  xhr.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr.responseText);
        $count = data['count'];
        if ($count) {
          setModal(true,'Request emails were sent');
          list = document.getElementsByTagName("input");
          for (let index = 0; index < list.length; index++) {
            list[index].value = "";
          }
        } else {
          setModal(false,'No emails were sent');
        }
      } catch (error) {
        alert("Error occured");
      }
    }
  };
}