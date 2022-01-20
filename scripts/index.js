function showVaccinationInfo(){
 document.getElementById("vaccinationInfo").style.display="block";
 document.getElementById("testingInfo").style.display="none";
}
function showTestingInfo(){
  document.getElementById("vaccinationInfo").style.display="none";
  document.getElementById("testingInfo").style.display="block";
}
function hideOthers(){
  document.getElementById("vaccinationInfo").style.display="none";
  document.getElementById("testingInfo").style.display="none";
}