function getCert() {
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

  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.responseType = 'blob';
  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('id', id);
  xhrBuilder.addField('token', token);
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = async function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      let cont_type = xhr.getResponseHeader('Content-Type');
      if (cont_type === 'application/pdf') {
        let blob = new Blob([this.response], { type: 'application/pdf' });
        let a = document.createElement("a");
        a.style = "display: none";
        a.target = '_blank';
        document.body.appendChild(a);
        let url = window.URL.createObjectURL(blob);
        a.href = url;
        a.download = id + '.pdf';
        a.click();
        window.URL.revokeObjectURL(url);
      } else {
        try {
          let blob = new Blob([this.response], { type: 'application/json' });
          const jsonData = await (new Response(blob)).text();
          let data = JSON.parse(jsonData);
          doses = data['doses'];
          if (doses != undefined && doses != null && Array.isArray(doses) && doses.length == 0) {
            setModal(false, 'Are you sure you are vaccinated?\nthen enter the correct id and token');
          } else {
            setModal(false, 'Error occured!');
          }
        } catch (error) {
          setModal(false, 'Error occured');
        }
      }
    }
  };
}

function keypress(e, n) {
  if (e.keyCode === 13) {
    e.preventDefault();
    if (n === 0) {
      document.getElementById('inputToken').focus();
    } else if (n === 1) {
      document.getElementById('submitBtn').click();
    }
  }
}