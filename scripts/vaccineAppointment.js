function getCentres() {
  let district = document.getElementById("districts").value;
  let date = document.getElementById("date").value;
  let id = document.getElementById("id").value;
  let output = document.getElementById("centers");
  output.style.backgroundColor="";
  document.getElementById("hide").style.display="none";
  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('district', district);
  xhrBuilder.addField('date', date);
  xhrBuilder.addField('id', id);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        while (output.firstChild){
          output.removeChild(output.lastChild);
        }
        let data = JSON.parse(xhr.responseText);
        let content = "";
        let possibleVaccines = ["Pfizer", "Sinopharm", "Aztraseneca", "Moderna"];
        data.forEach(centre => {
          let li = document.createElement('li');
          let span = document.createElement('span');
          span.innerText = centre['place'];
          li.appendChild(span);
          let ol = document.createElement('ol');
          for (i = 0; i < possibleVaccines.length; i++) {
            if (centre[possibleVaccines[i]] != undefined) {
              let vaccine_name = possibleVaccines[i];
              let availability = centre[possibleVaccines[i]]['appointments'];
              let text = centre["place"] + "?" + vaccine_name;
              let li2 = document.createElement('li');
              let span2 = document.createElement('span');
              span2.innerText = vaccine_name + " : " + availability;
              li2.appendChild(span2);
              let inp = document.createElement('input');
              inp.setAttribute('type', 'radio');
              inp.setAttribute('name', 'appointment');
              inp.setAttribute('value', text);
              li2.appendChild(inp);
              ol.appendChild(li2);
            }
          }
          li.appendChild(ol);
          output.appendChild(li);
          output.style.backgroundColor="black";
          document.getElementById("hide").style.display="block";
        });
      } catch (error) {
        alert("Error occured");
      }
    }
  }
}

function submitRequest() {
  let elem = document.querySelector('input[name="appointment"]:checked');
  if (!elem) return;
  let text = elem.value.split("?");
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

  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr.responseText);
        let msg=data["status"] === true ? "Appointment Success!" : "Appointment Failed!"
        setModal(data['status'],msg);
      } catch (error) {
        alert("Error occured");
      }
    }
  }
}