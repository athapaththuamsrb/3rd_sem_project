let resultTable = document.getElementById("resultTable");
document.getElementById('date').valueAsDate = new Date();

function getAvailability() {
  let district = document.getElementById("district").value;
  let type = document.getElementById("type").value;
  let dose = document.getElementById("dose").value;
  let date = document.getElementById("date").value;

  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );

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
  let data = [{
    place: 'General Hosp. Kalutara',
    Pfizer: 30,
    Sinopharm: 40
  },
  {
    place: 'Base Hosp. Horana',
    Aztraseneca: 70,
    Sinopharm: 40,
    Moderna: 50
  },
  {
    place: 'MOHGampaha',
    Pfizer: 60,
    Moderna: 100
  }
  ]

  let output = document.getElementById("resultTable");
  var tableContent = "<tr><th>Place</th><th></th></tr>"
  for (index = 0; index < data.length; index++) {
    var place = data[index]["place"]
    tableContent += "<tr><td>" + data[index]["place"] + "</td>" +
      "<td>" + '<input type="button" value="Show" onclick="submit2()">' + "</td></tr>";
  }
  output.innerHTML = tableContent;
}

function submit2() {
  console.log("hi")
}