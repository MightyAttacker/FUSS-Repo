google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(drawLineChart);
google.charts.setOnLoadCallback(drawPieChart);

function drawLineChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);

      var options = {
        curveType: 'function',
        title: 'Active users',
        backgroundColor: 'grey',
        legend: {position: 'bottom'},
        width:'100%',
        height:400
      }
      // Instantiate and draw the chart.
      var chart = new google.visualization.LineChart(document.getElementById('lineChartContent'));
      chart.draw(data, options);
    }

function drawPieChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     10],
        ]);

      var options = {
        title: 'Task Completion',
        backgroundColor: 'grey',
        legend: {position: 'bottom'},
        width:'100%',
        height:400
      }

        var chart = new google.visualization.PieChart(document.getElementById('pieChartContent'));

        chart.draw(data, options);
      }