$(document).ready(function() {
    // Получаем список сообщений при загрузке страницы
    
  
   $(document).on('keydown', 'textarea', function(event) {
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
   // Отправка сообщения при отправке формы
   $(document).on('submit', '#chat-form', function(event) {
    event.preventDefault();
    var message = $('#chat-message').val();
    if (message != '') {
      sendMessage(message);
      $('#chat-message').val('');
    }
  });

  $(document).on('submit', '#update', function(event) {
    event.preventDefault();
    var email = $('#Email').val();
    var respon = $('#Respon').val();
    var watcher = $('#Watcher').val();
    var statusi = $('#Statusi').val();
    var processing = $('#Processing').val();
      Update(email, respon, watcher, statusi, processing);
      
    
  });
   
      $('.form-get').submit(function(event) {
        event.preventDefault();
        var message = $(this).find('.idd').val();
         getChat(message);
         setInterval(function() {
          getMessages();
         }, 5000);
        });

        setInterval(function() {
          UpdatePage();
         }, 2000);
   
    // Обновление списка сообщений каждые 5 секунд

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

   function getChat(message) {
    $.ajax({
      url: 'get_chat.php',
      type: 'POST',
      data: {message: message},
      success: function(data) {
        
        $('#vou').html(data);
        setTimeout(()=>{ scrollToBottom();},200);
       
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

      function Update(email, respon, watcher, statusi, processing) {
        $.ajax({
         url: 'update_status.php',
         type: 'POST',
         data: {email: email, respon: respon, watcher: watcher, statusi:statusi, processing: processing},
         success: function() {
          UpdatePage();
         }
        });
       }

       function UpdatePage() {
        $.ajax({
         url: 'update_page.php',
         type: 'POST',
         success: function(data) 
         {
          $('#requests').html(data);
         }
        });
       }
     
      function scrollToBottom() {
       var chatMessages = document.getElementById('messages');
       chatMessages.scrollTop = chatMessages.scrollHeight;
      }

      function insertLineBreak() {
        // Вставляем перенос строки в текущую позицию курсора
        var textarea = document.getElementById('chat-message');
        var currentPosition = textarea.selectionStart;
        var text = textarea.value;
        var newText = text.substring(0, currentPosition) + '\n' + text.substring(currentPosition);
        textarea.value = newText;
      
        // Перемещаем курсор на новую строку
        textarea.selectionStart = textarea.selectionEnd = currentPosition + 1;
      }