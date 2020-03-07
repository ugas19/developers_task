var result = [];
var labels = [];
(function ($, Drupal, drupalSettings) {

  Drupal.behaviors.my_custom_behavior = {
    attach: function (context, settings) {
      var strings = drupalSettings.myvar;
      for (var i = 0; i < strings.length; i++) {
        if(strings[i][0] != null && strings[i][1] != null){
          result.push(strings[i][0]);
          result.push(strings[i][1]);
          labels.push('DeveloperPlanned')
          labels.push('DeveloperReal')
        }

      }
      chart();

    }
  }
  function chart() {
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
      label: 'geltona',
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          data: result,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
          ],
          borderColor: [
            'rgb(0,56,255)',
            'rgba(54, 162, 235, 1)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        },
        legend: {
          display: false,
        }
      }
    });
    console.log(result);
  }


})(jQuery, Drupal, drupalSettings);
