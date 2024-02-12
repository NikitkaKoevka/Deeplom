function rateFunction(button) {
    // Получение данных из формы
    var formData = $(button).closest('form').serialize();
    console.log(formData);
    // Отправка AJAX-запроса с использованием jQuery

    $.ajax({
        url: 'Rate.php',
        type: 'POST',
        data: formData,
        success: function(data) {
            // Обработка ответа от сервера, если необходимо
            console.log(data);
        },
        error: function(error) {
            // Обработка ошибок, если необходимо
            console.error("Ошибка:", error);
        }
    });
}

