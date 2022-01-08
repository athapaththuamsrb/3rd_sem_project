let currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  let x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == x.length - 1) {
    document.getElementById("nextBtn").innerText = "Submit";
  } else {
    document.getElementById("nextBtn").innerText = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n);
}

function nextPrev(n) {
  // This function will figure out which tab to display

  let x = document.getElementsByClassName("tab");

  //location input only for vaccine accounts
  if (n == 1) {
    if (document.getElementById("Administrator").checked) {
      document.getElementById("address").classList.add("hide");
    } else {
      document.getElementById("address").classList.remove("hide");
    }
  }

  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) {
    return false;
  }
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  if (currentTab == 0 && document.getElementById("Administrator").checked) {
    currentTab = currentTab + 2 * n;
  } else if (currentTab == 2 && document.getElementById("Administrator").checked) {
    if (n == 1) currentTab = currentTab + n;
    else currentTab = currentTab + 2 * n;
  } else {
    currentTab = currentTab + n;
  }
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    let pass = document.getElementById("password").value;
    if (/^[\x21-\x7E]{8,15}$/.test(pass) && pass === document.getElementById("conPassword").value) {
      submitForm();
    } else {
      alert("check your password again");
      currentTab = currentTab - n;
      x[currentTab].style.display = "block";
    }
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  let x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  if (currentTab == 2) {
    let email = document.getElementById("email").value;
    if (!email_pattern.test(email)) {
      return false;
    }
  }
  for (i = 0; i < y.length; i++) {
    if (currentTab != 0 && valid == true) {
      valid = y[i].value == "" ? false : true;
      if (!valid) return false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  let i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}

function submitForm() {
  let type = document.querySelector('input[name="type"]:checked').value;
  let district = document.getElementById("districts").value;
  let place = document.getElementById("place").value;
  let email = document.getElementById("email").value;
  let username = document.getElementById("username").value;
  let password = document.getElementById("password").value;

  let xhrBuilder = new XHRBuilder();
  xhrBuilder.addField('type', type);
  xhrBuilder.addField('district', district);
  xhrBuilder.addField('place', place);
  xhrBuilder.addField('email', email);
  xhrBuilder.addField('username', username);
  xhrBuilder.addField('password', password);

  let xhr = new XMLHttpRequest();
  xhr.open("POST", document.URL, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(xhrBuilder.build());
  xhr.onreadystatechange = function () {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr.responseText);
        if (data['success']) {
          document.getElementById("password").value = '';
          document.getElementById("conPassword").value = '';
          alert("Success");
          window.location.replace('/admin/');
        } else {
          alert("Failed!");
          let i, x = document.getElementsByClassName("step");
          for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" finish", "").replace(" active", "");
          }
          currentTab = 0
          showTab(currentTab);
        }
      } catch (error) {
        alert("Error occured");
      }
    }
  };
}

function keypress(e, n) {
  if (e.keyCode === 13) {
    e.preventDefault();
    if (n === 0) {
      document.getElementById('nextBtn').click();
      document.getElementById('email').focus();
    } else if (n === 1) {
      document.getElementById('nextBtn').click();
      document.getElementById('username').focus();
    } else if (n === 2) {
      document.getElementById('nextBtn').click();
      document.getElementById('password').focus();
    } else if (n === 3) {
      document.getElementById('conPassword').focus();
    } else if (n === 4) {
      document.getElementById('nextBtn').click();
    }
  }
}