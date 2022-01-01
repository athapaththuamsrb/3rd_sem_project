const output = document.getElementById("results");

function getStatus() {
  let id = document.getElementById("inputID").value;

  var xhr = new XMLHttpRequest();
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
          var tableContent = "<table><tr><th>Type</th><th>Date</th></tr>";
          for (index = 0; index < data.length; index++) {
            tableContent += "<tr><td>" + data[index]["type"] + "</td><td>" + data[index]["date"] + "</td></tr>";
          }
          tableContent += "</table>";
          output.innerHTML = tableContent;
        } else if (data.length == 0) {
          output.innerHTML = '<h2>Not vaccinated</h2>';
        } else {
          output.innerHTML = '<h2>Error occured!</h2><p>Couldn\'t load vaccination status.</p>';
        }
      } catch (error) {
        alert("Error occured");
      }
    }
  };
}