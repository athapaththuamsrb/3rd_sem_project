function getDateStr() {
  let d = new Date();
  let month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear();

  if (month.length < 2)
    month = '0' + month;
  if (day.length < 2)
    day = '0' + day;

  return [year, month, day].join('-');
}
let resultTable = document.getElementById("resultTable");
document.getElementById('date').value = getDateStr();

function getAvailability() {
  let district = document.getElementById("district").value;
  let type = document.getElementById("type").value;
  let dose = document.getElementById("dose").value;
  let date = document.getElementById("date").value;

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
        let data = JSON.parse(xhr.responseText);
        if (data) {
          let content = '<tr><th>Place</th><th>Online booking</th><th>Without Booking</th></tr>'; // TODO : use suitable heading
          data.forEach(elem => {
            content += '<tr><td>' + elem['place'] + '</td><td>' + elem['booking'] + '</td><td>' + elem['not_booking'] + "</td></tr>";
          });
          resultTable.innerHTML = content;
        }
      } catch (error) {
        alert("Error occured");
      }
    }
  };
  return;
}