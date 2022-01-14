function donate() {
  let type = document.getElementById("type").value;
  let place = document.getElementById("place").value;
  let dose = document.getElementById("dose").value;
  let amount = document.getElementById("amount").value;
  amount = parseInt(amount);
  dose = parseInt(dose);
  if (!type || !place || !dose || !amount || dose <= 0 || amount <= 0) {
    setModal(false, "Entered data is invalid");
    return false;
  }

  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('type', type);
  xhrBuilder.addField('place', place);
  xhrBuilder.addField('dose', dose);
  xhrBuilder.addField('amount', amount);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr.responseText);
        let success = data['success'];
        let email = data['email'];
        if (success) {
          alert('Donation completed.\n' + (email ? 'Email is sent' : 'But email is not sent. You have to inform the relevent centre admin'));
          list = document.getElementsByTagName("input");
          for (let index = 0; index < list.length; index++) {
            list[index].value = "";
          }
        } else {
          alert('Error : Donation failed');
        }
      } catch (error) {
        alert("Error occured");
      }
    }
  };
}