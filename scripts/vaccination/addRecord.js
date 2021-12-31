const district_element = document.getElementById("district");
const address_element = document.getElementById("address");
const id_element = document.getElementById("id");
const name_element = document.getElementById("name");
const contact_element = document.getElementById("ContactNo");
const email_element = document.getElementById("email");
const result_table = document.getElementById("resultTable");

function getDetails() {
  let id = id_element.value;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );
  //xhr.send("id=" + encodeURIComponent(id));
  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('id', id);
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      document.getElementById("hide").style.display = 'block';
      let data = JSON.parse(xhr.responseText);
      if (!data) return;
      var tableContent = "<tr><th>Type</th><th>Date</th></tr>";
      for (index = 0; index < data["doses"].length; index++) {
        tableContent +=
          "<tr><td>" +
          data["doses"][index]["type"] +
          "</td>" +
          "<td>" +
          data["doses"][index]["date"] +
          "</td></tr>";
      }
      result_table.innerHTML = tableContent;

      if (data["district"]) {
        district_element.value = data["district"];
        district_element.setAttribute("disabled", true);
      } else {

      }
      if (data["name"]) {
        name_element.value = data["name"];
        name_element.setAttribute("readonly", true);
      }
      if (data["address"]) {
        address_element.value = data["address"];
        address_element.setAttribute("readonly", true);
      }
      if (data["contact"]) {
        contact_element.value = data["contact"];
        contact_element.setAttribute("readonly", true);
      }
      if (data["email"]) {
        email_element.value = data["email"];
        email_element.setAttribute("readonly", true);
      }
    }
  };
}

function submitRecord() {
  if (!document.querySelector('input[name="type"]:checked')) {
    alert("You must select the vaccine type");
    return false;
  }
  let id = id_element.value;
  let name = name_element.value;
  let district = district_element.value;
  let vaccineType = document.querySelector(
    'input[name="type"]:checked'
  ).value;
  let address = address_element.value;
  let email = email_element.value;
  let contact = contact_element.value;

  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('id', id);
  xhrBuilder.addField('name', name);
  xhrBuilder.addField('district', district);
  xhrBuilder.addField('type', vaccineType);
  xhrBuilder.addField('address', address);
  if (email) xhrBuilder.addField('email', email);
  if (contact) xhrBuilder.addField('contact', contact);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      let data = JSON.parse(xhr.responseText);
      if (data && data["token"]) {
        alert("token is: " + data["token"]);
        // clear form
        list = document.getElementsByTagName("input");
        for (let index = 0; index < list.length; index++) {
          list[index].value = "";
          list[index].removeAttribute("readonly");
        }
        result_table.innerHTML = "";
        document.getElementById("hide").style.display = 'none';
      }
    }
  };
}