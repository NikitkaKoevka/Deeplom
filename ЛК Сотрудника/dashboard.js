$.ajax({
    url: 'getRatingData.php',
    type: 'GET',
    success: function(data) {
        console.log(data);
        var ratingData = JSON.parse(data);


        // Создаем круговую диаграмму
        var ctx = document.getElementById('ratingChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['плохо','хуже','средне','хорошо','отлично'],
                datasets: [{
                    data: ratingData,
                    backgroundColor: ['#FF5733', '#FFA933', '#FFE633', '#A3FF33', '#33FF57'],
                }],
            },

        });
    },
    error: function(error) {
        console.error("Ошибка:", error);
    }
});

$.ajax({
    url: 'getStatusData.php',
    type: 'GET',
    success: function(data) {
        console.log(data);
        var statusData = JSON.parse(data);


        // Создаем круговую диаграмму
        var ctx = document.getElementById('ratingChart2').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['в процессе','завершено'],
                datasets: [{
                    data: statusData,
                    backgroundColor: ['#A3FF33', '#33FF57'],
                }],
            },

        });
    },
    error: function(error) {
        console.error("Ошибка:", error);
    }
});
$.ajax({
    url: 'getCountData.php', 
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        // Построение гистограммы
        console.log(data);
        buildChart(data);
    },
    error: function(error) {
        console.error("Ошибка:", error);
    }
});

// Функция для построения гистограммы
function buildChart(data) {
    var ctx = document.getElementById('ratingChart3').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
            datasets: [{
                label: 'Кол-во завершенных заявок',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
