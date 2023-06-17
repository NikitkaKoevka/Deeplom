$(document).ready(function() {
    // Получаем список сообщений при загрузке страницы
    setTimeout(()=>{ scrollToBottom();},100);
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
       var chatMessages = document.getElementById('messages');
       chatMessages.scrollTop = chatMessages.scrollHeight;
      }


  