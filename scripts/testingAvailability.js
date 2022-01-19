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
  let date = document.getElementById("date").value;
  let today = new Date().setHours(0,0,0,0)
  if (new Date(date).getTime() < new Date(today).getTime()) {
    setModal(false, "Entered date is invalid");
    return false;
  }

  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('district', district);
  xhrBuilder.addField('type', type);
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
          tableBuilder.addHeadingRow('Place', 'Remaining Online Appointments', 'Walk-in Tests'); 
          data.forEach(elem => {
            tableBuilder.addRow(elem['place'], elem['appointments'], elem['not_booking']);
          });
          let table = tableBuilder.build();
          resultDiv.appendChild(table);
        } else {
          setModal(false, "Sorry.\nTesting Centers are not available.");
          return false;

          // let p = document.createElement('p');
          // p.innerText = 'Not Available'
          // resultDiv.appendChild(p);
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