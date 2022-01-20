// Load google charts
var ready = false;
google.charts.load('current', {
  'packages': ['corechart']
});
google.charts.setOnLoadCallback(() => {
  ready = true;
});
document.getElementById('district').onchange = drawChart;

// Draw the chart and set the chart values
function drawChart() {
  if (!ready) {
    document.getElementById('district').value = '';
    alert('Please wait a few seconds');
    return;
  }
  let district = document.getElementById('district').value;

  // get data for tests
  let xhr0 = new XMLHttpRequest();
  xhr0.open("POST", document.URL, true);
  xhr0.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  let xhrBuilder0 = new XHRBuilder();
  xhrBuilder0.addField('district', district);
  xhrBuilder0.addField('dose', 0);
  xhr0.send(xhrBuilder0.build());
  xhr0.onreadystatechange = function () {
    if (xhr0.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr0.responseText);
        if (data && data['result']) {
          let result = Object.keys(data['result']).map(type => [type, data['result'][type]]);
          let dataArr = [['Vaccine Type', 'count']];
          dataArr.push(...result);

          //test piechart
          var data_test = google.visualization.arrayToDataTable(dataArr);
          var options_test = {
            'title': 'Covid tests',
            'width': 500,
            'height': 450,
            'fontSize': 13,
          };
          var chart_test = new google.visualization.PieChart(document.getElementById('piechart-test'));
          chart_test.draw(data_test, options_test);
        }
      } catch (error) {
      }
    }
  };

  // get data for dose 1
  let xhr1 = new XMLHttpRequest();
  xhr1.open("POST", document.URL, true);
  xhr1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  let xhrBuilder1 = new XHRBuilder();
  xhrBuilder1.addField('district', district);
  xhrBuilder1.addField('dose', 1);
  xhr1.send(xhrBuilder1.build());
  xhr1.onreadystatechange = function () {
    if (xhr1.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr1.responseText);
        if (data && data['result']) {
          let result = Object.keys(data['result']).map(type => [type, data['result'][type]]);
          let dataArr = [['Vaccine Type', 'count']];
          dataArr.push(...result);

          //dose-1 piechart
          var data_dose_1 = google.visualization.arrayToDataTable(dataArr);
          var options_dose_1 = {
            'title': 'Dose 1',
            'width': 411,
            'height': 350,
            'fontSize': 15,
          };
          var chart_test = new google.visualization.PieChart(document.getElementById('piechart-vaccination-dose-1'));
          chart_test.draw(data_dose_1, options_dose_1);
        }
      } catch (error) {
      }
    }
  };

  // get data for dose 2
  let xhr2 = new XMLHttpRequest();
  xhr2.open("POST", document.URL, true);
  xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  let xhrBuilder2 = new XHRBuilder();
  xhrBuilder2.addField('district', district);
  xhrBuilder2.addField('dose', 2);
  xhr2.send(xhrBuilder2.build());
  xhr2.onreadystatechange = function () {
    if (xhr2.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr2.responseText);
        if (data && data['result']) {
          let result = Object.keys(data['result']).map(type => [type, data['result'][type]]);
          let dataArr = [['Vaccine Type', 'count']];
          dataArr.push(...result);

          //dose-1 piechart
          var data_dose_2 = google.visualization.arrayToDataTable(dataArr);
          var options_dose_2 = {
            'title': 'Dose 2',
            'width': 411,
            'height': 350,
            'fontSize': 15,
          };
          var chart_test = new google.visualization.PieChart(document.getElementById('piechart-vaccination-dose-2'));
          chart_test.draw(data_dose_2, options_dose_2);
        }
      } catch (error) {
      }
    }
  };

  // get data for dose 3
  let xhr3 = new XMLHttpRequest();
  xhr3.open("POST", document.URL, true);
  xhr3.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  let xhrBuilder3 = new XHRBuilder();
  xhrBuilder3.addField('district', district);
  xhrBuilder3.addField('dose', 3);
  xhr3.send(xhrBuilder3.build());
  xhr3.onreadystatechange = function () {
    if (xhr3.readyState == XMLHttpRequest.DONE) {
      try {
        let data = JSON.parse(xhr3.responseText);
        if (data && data['result']) {
          let result = Object.keys(data['result']).map(type => [type, data['result'][type]]);
          let dataArr = [['Vaccine Type', 'count']];
          dataArr.push(...result);

          //dose-1 piechart
          var data_dose_3 = google.visualization.arrayToDataTable(dataArr);
          var options_dose_3 = {
            'title': 'Dose 3',
            'width': 411,
            'height': 350,
            'fontSize': 15,
          };
          var chart_test = new google.visualization.PieChart(document.getElementById('piechart-vaccination-dose-3'));
          chart_test.draw(data_dose_3, options_dose_3);
        }
      } catch (error) {
      }
    }
  };
}