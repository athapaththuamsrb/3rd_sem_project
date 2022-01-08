const district_element = document.getElementById("district");
const address_element = document.getElementById("address");
const id_element = document.getElementById("id");
const name_element = document.getElementById("name");
const contact_element = document.getElementById("ContactNo");
const email_element = document.getElementById("email");
const result = document.getElementById("resultDiv");

function reset() {
  while (result.firstChild) {
    result.removeChild(result.lastChild);
  }
  district_element.value = 'Colombo';
  district_element.removeAttribute("disabled");
  name_element.value = '';
  name_element.removeAttribute("readonly");
  address_element.value = '';
  address_element.removeAttribute("readonly");
  contact_element.value = '';
  contact_element.removeAttribute("readonly");
  email_element.value = '';
  email_element.removeAttribute("readonly");
}

function getDetails() {
  let id = id_element.value;
  if(id.length<4 || id.length>12){
    alert("Invalid ID!");
    return;
  }
  let xhr = new XMLHttpRequest();
  xhr.open('POST', document.URL, true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('id', id);
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        reset();
        document.getElementById("hide").style.display = 'block';
        let data = JSON.parse(xhr.responseText);
        if (!data || data["doses"] == undefined || !Array.isArray(data["doses"]) || data["doses"].length <= 0) {
          return;
        };
        let tableBuilder = new TableBuilder();
        tableBuilder.addHeadingRow('Type', 'Date');
        data['doses'].forEach(dose => {
          tableBuilder.addRow(dose['type'], dose['date']);
        });
        let table = tableBuilder.build();
        result.appendChild(table);
        if (data["district"]) {
          district_element.value = data["district"];
        }
        district_element.setAttribute("disabled", true);
        if (data["name"]) {
          name_element.value = data["name"];
        }
        name_element.setAttribute("readonly", true);
        if (data["address"]) {
          address_element.value = data["address"];
        }
        address_element.setAttribute("readonly", true);
        if (data["contact"]) {
          contact_element.value = data["contact"];
        }
        contact_element.setAttribute("readonly", true);
        if (data["email"]) {
          email_element.value = data["email"];
        }
        email_element.setAttribute("readonly", true);
      } catch (error) {
        alert("Error occured");
        reset();
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
  let vaccineType = document.querySelector('input[name="type"]:checked').value;
  let address = address_element.value;
  let email = email_element.value;
  let contact = contact_element.value;

  if(id.length<4 || id.length>12){//check id
    alert("Invalid ID!");
    return false;
  }
  if(!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email)){
    alert("Invalid email");
    return false;
  }
  if(!/^(\+[0-9]{1,3})|(0)[0-9]{9}$/.test(contact)){
    alert("Invalid contact number");
    return false;
}
  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('id', id);
  xhrBuilder.addField('name', name);
  xhrBuilder.addField('district', district);
  xhrBuilder.addField('type', vaccineType);
  xhrBuilder.addField('address', address);
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
        if (data && data["token"]) {
          setModal(true,"token is: " + data["token"]);
          reset();
          id_element.value = "";
          // clear form
          // list = document.getElementsByTagName("input");
          // for (let index = 0; index < list.length; index++) {
          //   list[index].value = "";
          //   list[index].removeAttribute("readonly");
          // }
          // while (result.firstChild) {
          //   result.removeChild(result.lastChild);
          // }
          document.getElementById("hide").style.display = 'none';
        }
        else{
          setModal(false,"Error occured!");
        }
      } catch (error) {
        setModal(false,"Error occured!");
      }
    }
  };
}

function keypress(e, n) {
  if (e.keyCode === 13) {
    e.preventDefault();
    if (n === 0) {
      document.getElementById('submitButton1').click();
    }else{
      let elem = document.getElementById(n);
      if (elem){
        elem.focus();
      }
    }
  }
}