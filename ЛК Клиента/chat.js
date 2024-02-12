
$(document).ready(function() {
    // Получаем список сообщений при загрузке страницы
    scrollToBottom();
    getMessages();
    
    var textarea = document.getElementById('chat-message');
           textarea.addEventListener('keydown', function(event) {
             if (event.key === 'Enter' && event.ctrlKey) {
               event.preventDefault(); // Отменяем стандартное действие (перенос строки)
               insertLineBreak(); // Вызываем функцию вставки переноса строки
             }else if (event.key === 'Enter') {
               event.preventDefault();
               var message = $('#chat-message').val();
               if (message != '') {
                sendMessage(message);
                $('#chat-message').val('');
               } // Вызываем функцию отправки сообщения
             }
         });

   
   function insertLineBreak() {
     // Вставляем перенос строки в текущую позицию курсора
     var currentPosition = textarea.selectionStart;
     var text = textarea.value;
     var newText = text.substring(0, currentPosition) + '\n' + text.substring(currentPosition);
     textarea.value = newText;
     
     // Перемещаем курсор на новую строку
     textarea.selectionStart = textarea.selectionEnd = currentPosition + 1;
   }
   // Отправка сообщения при отправке формы
   $('#chat-form').submit(function(event) {
       event.preventDefault();
       var message = $('#chat-message').val();
       if (message != '') {
        sendMessage(message);
        $('#chat-message').val('');
        
       
       }
       
      });
   
    // Обновление списка сообщений каждые 5 секунд
    setInterval(function() {
     getMessages();
    }, 5000);
   });
   



   function getMessages() {
    $.ajax({
     url: 'get_messages.php',
     type: 'POST',
     success: function(data) 
     {
      $('#messages').html(data);
      
     }
    });
   }
   
   function sendMessage(message) {
       $.ajax({
        url: 'send_message.php',
        type: 'POST',
        data: {message: message},
        success: function() {
         getMessages();
         setTimeout(()=>{ scrollToBottom();},600);
        }
       });
      }
    
      function scrollToBottom() {
      console.log('f');
       var chatMessages = document.getElementById('messages');
       chatMessages.scrollTop = chatMessages.scrollHeight;
      }


  //--------------------------------------------------------------------------------------------------------
//Ниже код для прикрепления фотки в переписку

var labelElement = document.getElementById('paperclip');

if (labelElement) {

    
    labelElement.addEventListener('change', function() 
    {
        
        var fileInput = document.getElementById('paperclip');
        console.log(fileInput);
        // Проверяем, выбран ли файл
        if (fileInput.files.length > 0) {
            var file = fileInput.files[0];
            var formData = new FormData();
            formData.append('doc', file);
  
            // Отправляем файл на сервер с использованием AJAX
            $.ajax({
                url: 'send_file.php', // Путь к вашему PHP-обработчику
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.error('Ошибка при загрузке файла: ' + error);
                }
            });
        } else {
            console.log('Выберите файл для загрузки.');
        }


    });
}

//--------------------------------------------------------------------------------------------------------------------------
      // Ниже код для обработки удаления сообщения в переписке нажатием правой кнопки мыши

      function showContextMenu(event, messageId) {
        event.preventDefault(); // Предотвращаем стандартное контекстное меню
      
        // Показываем пользовательское контекстное меню
        var contextMenu = document.getElementById('contextMenu');
        contextMenu.style.display = 'block';
        contextMenu.style.left = (event.pageX + 5) + 'px';
        contextMenu.style.top = (event.pageY + 5) + 'px';
      
        // Сохраняем ID выбранного сообщения
        contextMenu.setAttribute('data-message-id', messageId);
      }
      
      document.addEventListener('click', function (event) {
        var contextMenu = document.getElementById('contextMenu');
        contextMenu.style.display = 'none';
      });
      
      document.getElementById('deleteMessage').addEventListener('click', function () {
        var contextMenu = document.getElementById('contextMenu');
        var messageId = contextMenu.getAttribute('data-message-id');
        

      });
      //Удаляем сообщение
      function deleteMessage() 
      {
        var messageId = document.getElementById('contextMenu').getAttribute('data-message-id');
        console.log(messageId);
        $.ajax({
            url: 'Delete_message.php',
            type: 'POST',
            data: { messageId: messageId },
            success: function(response) 
            {
                
              console.log(response);
                
            },
            error: function(error) {
                console.error('Ошибка при удалении сообщения: ' + error);
            }
        });
    }
