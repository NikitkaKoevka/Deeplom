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


   /*
      $('.form-get').submit(function(event) {
        event.preventDefault();
        var message = $(this).find('.idd').val();
         getChat(message);
         setInterval(function() {
          getMessages();
         }, 5000);

        });
        */


// обновляем страницу каждые 2 секунды
   
        setInterval(function() {

          var sor = document.getElementById("sorti").value;
          UpdatePage(sor);
        }, 2000);
    

    // Обновление списка сообщений каждые 5 секунд

   });

   function OpenReq(sorti,idChat)
   {
     console.log(sorti);
     console.log(idChat);
     getChat(idChat);
     setInterval(function() {
       getMessages();
      }, 5000);

   }
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
        //--------------------------------------------------------------------------------------------------------
//Ниже код для прикрепления фотки в переписку

var labelElement = document.getElementById('paperclip');

if (labelElement) {
    labelElement.addEventListener('change', function() 
    {
        console.log('1');
        
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
//--------------------------------------------------------------------------------------------------------

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
        var sor = document.getElementById("sorti").value;
        $.ajax({
         url: 'update_status.php',
         type: 'POST',
         data: {email: email, respon: respon, watcher: watcher, statusi:statusi, processing: processing},
         success: function() {
          UpdatePage(sor);
         }
        });
       }

       function UpdatePage(sor) {

        $.ajax({
         url: 'update_page2.php',
         type: 'POST',
         data: {
          ID: sor
        },
         success: function(data) 
         {
          console.log(sor);
          $('#requests').html(data);
          //$('#sorti').val(sor);
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
        
        // Удаляем сообщение с соответствующим messageId
        var messageToDelete = document.getElementById(messageId);
        if (messageToDelete) {
          messageToDelete.remove();
          contextMenu.style.display = 'none';
        }
      });
      