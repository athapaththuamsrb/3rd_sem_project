const output = document.getElementById("results");

function getStatus() {
  let id = document.getElementById("inputID").value;

  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('id', id);
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr.responseText);
        if (data != null && Array.isArray(data) && data.length > 0) {
          let tableBuilder = new TableBuilder();
          tableBuilder.addHeadingRow('Type', 'Date');
          for (index = 0; index < data.length; index++) {
            tableBuilder.addRow(data[index]['type'], data[index]['date']);
          }
          while (output.firstChild){
            output.removeChild(output.lastChild);
          }
          let table = tableBuilder.build();
          output.appendChild(table);
        } else if (data.length == 0) {
          while (output.firstChild){
            output.removeChild(output.lastChild);
          }
          let h2 = document.createElement('h2');
          h2.innerText = 'Not vaccinated';
          output.appendChild(h2);
        } else {
          while (output.firstChild){
            output.removeChild(output.lastChild);
          }
          let h2 = document.createElement('h2');
          h2.innerText = 'Error occured!';
          let p = document.createElement('p');
          p.innerText = 'Couldn\'t load vaccination status.';
          output.appendChild(h2);
          output.appendChild(p);
        }
      } catch (error) {
        alert("Error occured");
      }
    }
  };
}