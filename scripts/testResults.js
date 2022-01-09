const output = document.getElementById("results");

function getResult() {
  let id = document.getElementById("inputID").value;
  let token = document.getElementById("inputToken").value;

  if (id.length < 4 || id.length > 12 || token.length != 6) {
    //check id
    alert("Invalid Details!");
    return false;
  }

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
        if (data && data['result']) {
          while (output.firstChild) {
            output.removeChild(output.lastChild);
          }
          let result = data['result'];
          let h2 = document.createElement('h2');
          h2.innerText = 'Result : ' + result;
          output.appendChild(h2);
        } else {
          while (output.firstChild) {
            output.removeChild(output.lastChild);
          }
          let h2 = document.createElement('h2');
          h2.innerText = 'Error occured!';
          let p = document.createElement('p');
          p.innerText = 'Couldn\'t load result.';
          output.appendChild(h2);
          output.appendChild(p);
        }
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