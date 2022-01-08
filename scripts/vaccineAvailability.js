function getDateStr() {
  let d = new Date();
  let month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear();

  if (month.length < 2)
    month = '0' + month;
  if (day.length < 2)
    day = '0' + day;

  return [year, month, day].join('-');
}
const resultDiv = document.getElementById("resultDiv");
document.getElementById("date").setAttribute("min", getDateStr());
document.getElementById('date').value = getDateStr();

function getAvailability() {
  let district = document.getElementById("district").value;
  let type = document.getElementById("type").value;
  let dose = parseInt(document.getElementById("dose").value, 10);
  let date = document.getElementById("date").value;

  if (dose < 1) {
    alert("Invalid Dose!");
    return false;
  }

  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('district', district);
  xhrBuilder.addField('type', type);
  xhrBuilder.addField('dose', dose);
  xhrBuilder.addField('date', date);
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        while (resultDiv.firstChild) {
          resultDiv.removeChild(resultDiv.lastChild);
        }
        let data = JSON.parse(xhr.responseText);
        if (data && Array.isArray(data) && data.length > 0) {
          let tableBuilder = new TableBuilder();
          tableBuilder.addHeadingRow('Place', 'Online booking', 'Without Booking'); // TODO : use suitable heading
          data.forEach(elem => {
            tableBuilder.addRow(elem['place'], elem['booking'], elem['not_booking']);
          });
          let table = tableBuilder.build();
          resultDiv.appendChild(table);
        } else {
          let p = document.createElement('p');
          p.innerText = 'Not Available'
          resultDiv.appendChild(p);
        }
      } catch (error) {
        alert("Error occured");
        while (resultDiv.firstChild) {
          resultDiv.removeChild(resultDiv.lastChild);
        }
      }
    }
  };
  return;
}