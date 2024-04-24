document.addEventListener('DOMContentLoaded', function () {
    // Datos de ejemplo para las gráficas
    var monthlySalesData = {
      labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
      datasets: [{
        label: 'Ventas Mensuales',
        data: [500, 800, 1200, 900, 1500, 1100],
        backgroundColor: ['#FF85A2', '#FFB4C3', '#FFD8E0', '#FFECEA', '#FFF4F3', '#FFF9F8'],
        hoverBackgroundColor: ['#FF85A2', '#FFB4C3', '#FFD8E0', '#FFECEA', '#FFF4F3', '#FFF9F8']
      }]
    };

    var annualSalesData = {
      labels: ['2021', '2022', '2023', '2024'],
      datasets: [{
        label: 'Ventas Anuales',
        data: [5000, 7000, 9000, 6500],
        backgroundColor: ['#FF85A2', '#FFB4C3', '#FFD8E0', '#FFECEA'],
        hoverBackgroundColor: ['#FF85A2', '#FFB4C3', '#FFD8E0', '#FFECEA']
      }]
    };

    // Opciones de configuración para las gráficas
    var options = {
      responsive: true,
      maintainAspectRatio: false,
      elements: {
        arc: {
          borderWidth: 0
        }
      }
    };

    // Crear las instancias de las gráficas
    var ctx1 = document.getElementById('monthlySalesChart').getContext('2d');
    new Chart(ctx1, {
      type: 'doughnut',
      data: monthlySalesData,
      options: options
    });

    var ctx2 = document.getElementById('annualSalesChart').getContext('2d');
    new Chart(ctx2, {
      type: 'doughnut',
      data: annualSalesData,
      options: options
    });
  });