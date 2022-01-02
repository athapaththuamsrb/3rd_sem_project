function getCentres() {
  let district = document.getElementById("districts").value;
  let date = document.getElementById("date").value;
  let id = document.getElementById("id").value;
  let output = document.getElementById("centers");

  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('district', district);
  xhrBuilder.addField('date', date);
  xhrBuilder.addField('id', id);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr.responseText);
        var content = "";
        var possibleVaccines = ["Pfizer", "Sinopharm", "Aztraseneca", "Moderna"];
        data.forEach(centre => {
          content += "<li>" + centre["place"] + "<ol>";
          for (i = 0; i < possibleVaccines.length; i++) {
            if (centre[possibleVaccines[i]] != undefined) {
              let vaccine_name = possibleVaccines[i];
              let availability = centre[possibleVaccines[i]]['appointments'];
              var text = centre["place"] + "?" + [vaccine_name];
              var editText = text.replace(/ /g, "@");
              content += "<li>" + [vaccine_name] + ":" + availability + '<input type = "radio"  name ="appoinment" value =' + editText + ' /> ' + '</li>';
            }
          }
          content += "</ol></li><br><br>";
        });
        output.innerHTML = content;
      } catch (error) {
        alert("Error occured");
      }
    }
  }
}

function submitRequest() {
  let elem = document.querySelector('input[name="appoinment"]:checked');
  if (!elem) return;
  var text = elem.value.replace(/@/g, " ").split("?");
  let district = document.getElementById("districts").value;
  let date = document.getElementById("date").value;
  let id = document.getElementById("id").value;
  let name = document.getElementById("name").value;
  let email = document.getElementById("email").value;
  let contact = document.getElementById("contact").value;

  let vaccineCenter = text[0];
  let vaccineType = text[1];

  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('district', district);
  xhrBuilder.addField('date', date);
  xhrBuilder.addField('id', id);
  xhrBuilder.addField('name', name);
  xhrBuilder.addField('vaccineType', vaccineType);
  xhrBuilder.addField('vaccineCenter', vaccineCenter);
  if (email) xhrBuilder.addField('email', email);
  if (contact) xhrBuilder.addField('contact', contact);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr.responseText);
        if (data['status']) {
          document.getElementById("mHeader").style.background = "green";
          document.getElementById("mFooter").style.background = "green";
          document.getElementById("mBody").innerHTML = "<p>Appointment Success!</p>";
          document.getElementById("mFooter").innerHTML = "<h3>Thank you!</h3>";
          modal.style.display = "block";
        } else {
          // alert('appointment failed');
          document.getElementById("mHeader").style.background = "red";
          document.getElementById("mFooter").style.background = "red";
          document.getElementById("mBody").innerHTML = "<p>Appointment Failed.</p>";
          document.getElementById("mFooter").innerHTML = "<h3>Try Again!</h3>";
          modal.style.display = "block";
        }
      } catch (error) {
        alert("Error occured");
      }
    }
  }

}

// Get the modal
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];
span.onclick = function () {
  modal.style.display = "none";
}
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}