function getDateStr() {
  let d = new Date();
  d.setDate(d.getDate() + 1);
  let month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();

  if (month.length < 2) month = "0" + month;
  if (day.length < 2) day = "0" + day;

  return [year, month, day].join("-");
}

document.getElementById("date").setAttribute("min", getDateStr());

function getCentres() {
  let district = document.getElementById("districts").value;
  let date = document.getElementById("date").value;
  let id = document.getElementById("id").value;

  if (new Date(date).getTime() < new Date().getTime()) {
    setModal(false, "Entered date is invalid");
    return false;
  }
  if (date == '') {
    setModal(false, "Please enter the date");
    return false;
  }

  if (id.length < 4 || id.length > 12) {
    setModal(false, "Entered ID is invalid");
    return false;
  }

  let output = document.getElementById("centers");
  output.style.backgroundColor = "";
  document.getElementById("hide").style.display = "none";
  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField("district", district);
  xhrBuilder.addField("date", date);
  xhrBuilder.addField("id", id);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        while (output.firstChild) {
          output.removeChild(output.lastChild);
        }
        let data = JSON.parse(xhr.responseText);
        if (data.length == 0) {
          setModal(false, "Sorry.\nVaccine  Centers are not available.");
          return false;
        }
        data.forEach((centre) => {
          let li = document.createElement("li");
          let span = document.createElement("span");
          span.innerText = centre["place"];
          li.appendChild(span);
          let ol = document.createElement("ol");
          Object.keys(centre['types']).forEach((vaccine_name) => {
            let availability = centre['types'][vaccine_name]["appointments"];
            let text = centre["place"] + "?" + vaccine_name;
            let li2 = document.createElement("li");
            let span2 = document.createElement("span");
            span2.innerText = vaccine_name + " : " + availability;
            li2.appendChild(span2);
            let inp = document.createElement("input");
            inp.setAttribute("type", "radio");
            inp.setAttribute("name", "appointment");
            inp.setAttribute("value", text);
            li2.appendChild(inp);
            ol.appendChild(li2);
          });
          li.appendChild(ol);
          output.appendChild(li);
          output.style.backgroundColor = "black";
          document.getElementById("hide").style.display = "block";
        });
      } catch (error) {
        alert("Error occured");
      }
    }
  };
}

function submitRequest() {
  let elem = document.querySelector('input[name="appointment"]:checked');
  if (!elem) {
    setModal(false, "Please select an option");
    return false;
  }
  let text = elem.value.split("?");
  let district = document.getElementById("districts").value;
  let date = document.getElementById("date").value;
  let id = document.getElementById("id").value;
  let name = document.getElementById("name").value;
  let email = document.getElementById("email").value;
  let contact = document.getElementById("contact").value;

  let vaccineCenter = text[0];
  let vaccineType = text[1];

  if (id.length < 4 || id.length > 12) {
    setModal(false, "Invalid ID!");
    return false;
  }

  if (!name_pattern.test(name)) {
    setModal(false, "Invalid Name!");
    return false;
  }

  if (contact && !contact_pattern.test(contact)) {
    setModal(false, "Invalid Contact Number!");
    return false;
  }

  if (email && !email_pattern.test(email)) {
    setModal(false, "Invalid Email!");
    return false;
  }

  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField("district", district);
  xhrBuilder.addField("date", date);
  xhrBuilder.addField("id", id);
  xhrBuilder.addField("name", name);
  xhrBuilder.addField("vaccineType", vaccineType);
  xhrBuilder.addField("vaccineCenter", vaccineCenter);
  if (email) xhrBuilder.addField("email", email);
  if (contact) xhrBuilder.addField("contact", contact);

  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr.responseText);
        let msg =
          data["status"] === true
            ? "Appointment Success!"
            : "Appointment Failed!";
        setModal(data["status"], msg);
      } catch (error) {
        alert("Error occured");
      }
    }
  };
}
