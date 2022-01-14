const output = document.getElementById("results");
document.getElementById('inputID').focus();

function getResult() {
  let id = document.getElementById("inputID").value;
  let token = document.getElementById("inputToken").value;

  if (id.length < 4 || id.length > 12) {
    setModal(false, "Invalid ID!");
    return false;
  }

  if (token.length != 6) {
    setModal(false, "Invalid token!");
    return false;
  }

  // if (id.length < 4 || id.length > 12 || token.length != 6) {
  //   //check id
  //   alert("Invalid Details!");
  //   return false;
  // }

  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('id', id);
  xhrBuilder.addField('token', token);
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr.responseText);
        while (output.firstChild) {
          output.removeChild(output.lastChild);
        }
        let h2 = document.createElement('h2');
        if (data && data['result']) {
          let result = data['result'];
          h2.innerText = 'Result : ' + result;
        } else {
          h2.innerText = 'Couldn\'t load result';
        }
        output.appendChild(h2);
      } catch (error) {
        alert("Error occured");
      }
    }
  };
}

function keypress(e, n) {
  if (e.keyCode === 13) {
    e.preventDefault();
    if (n==0){
      document.getElementById('inputToken').focus();
    }
    else if (n==1){
    document.getElementById('submitBtn').click();}
  }
}