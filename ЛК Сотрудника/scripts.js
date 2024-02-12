var flag=1;
function togglePlaque() {
  var plaque = document.getElementById("plaque");
  if (plaque.style.display === "none" || flag == 1) {
    plaque.style.display = "block";
    plaque.style.opacity = "0";
    plaque.style.transition = "opacity 0.2s";
    setTimeout(function() {
      plaque.style.opacity = "1";
    }, 10);
    flag = 0;
  } else if (flag == 0) {
    plaque.style.opacity = "0";
    plaque.style.transition = "opacity 0.2s";
    setTimeout(function() {
      plaque.style.display = "none";
    }, 100);
  }
}


  function SupportAlert()
  {
    alert("Контакт поддержки сайта:\nТелефон:+7-495-183-54-99\ne-mail: k3support@gmail.com");
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
  //---------------------------------------------------------------------------------------------------
  //ниже код для поиска, он универсален для 4 страниц, все зависит от параметров которые в него передаются


  function searchFunc(typeOfSearching) {
    const searchInput = document.getElementById("searchInput").value.trim();
    const userListContainer = document.getElementById("userList");
    const FAQListContainer = document.getElementById("Occasions");
    const EquipListContainer = document.getElementById("EquipList");
    // Очищаем контейнер userListContainer перед отображением результатов

    switch(typeOfSearching)
    {
      case 'Clients': 
      { findFunc(searchInput,userListContainer,typeOfSearching);
        userListContainer.innerHTML = "";
      }
      break;
      case 'Employee': 
      { findFunc(searchInput,userListContainer,typeOfSearching);
        userListContainer.innerHTML = "";
      }
      break;
      case 'FAQ':
      { findFunc(searchInput,FAQListContainer,typeOfSearching);
        FAQListContainer.innerHTML = "";
      }
      break;
      case 'Equip':
        { findFunc(searchInput,EquipListContainer,typeOfSearching);
          EquipListContainer.innerHTML = "";
        }
        break;
    }

    //findFunc(searchInput,userListContainer,typeOfSearching);
}

function findFunc(searchInput,ListContainer,typeOfSearching) 
{
  // Выполняем AJAX-запрос к серверу
  $.ajax({
    url: 'search_users.php',
    type: 'POST',
    data: {
        searchInput: searchInput,
        searchType: typeOfSearching
    },
    success: function(data) {
        console.log("Response data:", typeOfSearching); // Отладочный вывод
        // Заменяем содержимое контейнера userListContainer результатами поиска
        ListContainer.innerHTML = data;
        // Подсчитываем количество найденных по запросу единиц
        if(typeOfSearching!='FAQ')
        countUserNumber();
    },
    error: function(error) {
        console.error("Ошибка при выполнении запроса: " + error);
    }
  });
}


function countUserNumber() 
{
  // Получить количество элементов
  var count = document.getElementsByClassName('ContentPlaque').length;
  console.log(count); // Отладочный вывод
  // Обновляем элемент, отображающий сумму 
  const allUsersCountElement = document.getElementById("All");
  allUsersCountElement.innerHTML =count;
}







//Ниже функция для загрузки контента FAQ------------------------------------------------------






function loadContent(button,option) {
  var themeID = $(button).data('id');
  var contentContainer = $(`.hidden-content[data-id='${themeID}']`);
  
    if (contentContainer.is(':visible')) {
    contentContainer.hide();
  } else {
    $.ajax({
      url: 'FAQ.php',
      type: 'POST',
      data: {
        Option:option,
        id: themeID
      },
      success: function(data) {
        console.log(option);
        // Обновляем содержимое contentContainer полученными данными
        contentContainer.html(data);
        contentContainer.show(); // Отображаем элемент
      },
      error: function(error) {
        console.error("Ошибка при выполнении запроса: " + error);
      }
    });
  }
}

//Ниже функции для модального окна создания FAQ.................................................................................

function addFAQ() {
  document.getElementById("myModal").style.display = "block";
}

function closeModal() {
  document.getElementById("myModal").style.display = "none";
}
function closeModal2() {
  document.getElementById("myModal2").style.display = "none";
}


function addNewFAQ(option) {
  const theme = document.getElementById("theme").value;
  const content = document.getElementById("content").value;
  const selectedRadio = document.querySelector('input[name="radio"]:checked');
  const selectedValue = selectedRadio ? selectedRadio.value : null;

  console.log(theme);

  if (theme && content && selectedValue) {
    // Все поля заполнены, выполните AJAX-запрос
    $.ajax({
      url: 'FAQ.php',
      type: 'POST',
      data: {
        Option:option,
        Theme: theme,
        Content: content,
        Type: selectedValue
      },
      success: function () {
        console.log("Успех!");
        // После успешной отправки, закройте модальное окно
        closeModal();
      },
      error: function (error) {
        console.error("Ошибка при выполнении запроса: " + error);
      }
    });
  } else {
    alert("Пожалуйста, заполните все поля.");
  }
}


//Ниже представлен код для изменения FAQ........................................................................................

function changeContent(button,option)
{
  document.getElementById("myModal2").style.display = "block";
  var themeID = $(button).data('id');
  // Задаем айдишник в data-id для кнопки изменения
  $('#myModal2 .bttnAddNewFAQ').attr('data-id', themeID);

  $.ajax({
    url: 'FAQ.php',
    type: 'POST',
    data: {
      Option:option,
      id: themeID
    },
    success: function(data) {
      console.log(option);
      
      // Разбираем JSON-строку
      var parsedData = JSON.parse(data);
      
      // Обновляем содержимое contentContainer полученными данными
      $('.modal2 #theme1').val(parsedData.theme);
      $('.modal2 #content1').val(parsedData.content);
    
      // Устанавливаем тип FAQ
      $('.modal2 input[name="radio1"][value="' + parsedData.type + '"]').prop('checked', true);
    
      
    },
    error: function(error) {
      console.error("Ошибка при выполнении запроса: " + error);
    }
  });

}

function ChangeFunc(button,option)
{

  var themeID = $(button).data('id');
  var Theme = document.getElementById("theme1").value;
  var content = document.getElementById("content1").value;
  var selectedRadio = document.querySelector('input[name="radio1"]:checked');
  var selectedValue = selectedRadio ? selectedRadio.value : null;

  console.log(Theme);
  console.log(content);
  console.log(selectedValue);
  if (Theme || content || selectedValue) {
    // Все поля заполнены, выполните AJAX-запрос
    $.ajax({
      url: 'FAQ.php',
      type: 'POST',
      data: {
        Option:option,
        id: themeID,
        Theme: Theme,
        Content: content,
        Type: selectedValue
      },
      success: function () {
        
        // После успешной отправки, закройте модальное окно
        closeModal2();
        location.reload();
      },
      error: function (error) {
        console.error("Ошибка при выполнении запроса: " + error);
      }
    });
  } else {
    alert("Вы ничего не изменили");
  }

}
function deleteContent(button,option)
{
  var themeID = $(button).data('id');
  $.ajax({
    url: 'FAQ.php',
    type: 'POST',
    data: {
      Option:option,
      id: themeID
    },
    success: function () {
      console.log("Успешно удалено!");
      location.reload();
    },
    error: function (error) {
      console.error("Ошибка при выполнении запроса: " + error);
    }
  });

}

function Service(option,UserType)
{
  $.ajax({
    url: 'FAQ.php',
    type: 'POST',
    data: {
      Option:option,
      UserType:UserType
    },
    success: function (data) {
      console.log("Успешно!");
      $('.Occasions').html(data);
    },
    error: function (error) {
      console.error("Ошибка при выполнении запроса: " + error);
    }
  });
}

function Accedent(option,UserType)
{
  $.ajax({
    url: 'FAQ.php',
    type: 'POST',
    data: {
      Option:option,
      UserType:UserType
    },
    success: function (data) {
      console.log("Успешно!");
      $('.Occasions').html(data);
    },
    error: function (error) {
      console.error("Ошибка при выполнении запроса: " + error);
    }
  });
}


//Ниже представлен код для создания и изменения сотрудников со стороны админов-------------------------------

function addSotrud() {
  document.getElementById("myModal").style.display = "block";
}
function closeModal() {
  document.getElementById("myModal").style.display = "none";
}
function closeModal2() {
  document.getElementById("myModal2").style.display = "none";
}


function addNewSotrud(option) 
{
  const name = document.getElementById("name").value;
  const lastname = document.getElementById("lastname").value;
  const phone = document.getElementById("phone").value;
  const email = document.getElementById("email").value;
  const type = document.getElementById("accessLevel").value;
  console.log(name);

  if (name && lastname && phone && email && type) {
    // Все поля заполнены, выполните AJAX-запрос
    $.ajax({
      url: 'Sotrud.php',
      type: 'POST',
      data: {
        name:name,
        lastname: lastname,
        email: email,
        phone:phone,
        type: type,
        option:option
      },
      success: function () {
        console.log("Успех!");
        // После успешной отправки, закройте модальное окно
        closeModal();
        location.reload();
      },
      error: function (error) {
        console.error("Ошибка при выполнении запроса: " + error);
      }
    });
  } else {
    alert("Пожалуйста, заполните все поля.");
  }
}


function changeEmployee(button,option)
{
  document.getElementById("myModal2").style.display = "block";
  var ID = $(button).data('id');
  console.log(ID);
  // Задаем айдишник в data-id для кнопки изменения
  $('#myModal2 .bttnAddNewSotrud').attr('data-id', ID);

  $.ajax({
    url: 'Sotrud.php',
    type: 'POST',
    data: {
      option:option,
      id: ID
    },
    success: function(data) {
      console.log(option);
      
      // Разбираем JSON-строку
      var parsedData = JSON.parse(data);
      
      // Обновляем содержимое contentContainer полученными данными
      $('.modal2 #name1').val(parsedData.name);
      $('.modal2 #lastname1').val(parsedData.lastname);
      $('.modal2 #email1').val(parsedData.email);
      $('.modal2 #phone1').val(parsedData.phone);
      $('.modal2 #accessLevel1').val(parsedData.type);
      
    },
    error: function(error) {
      console.error("Ошибка при выполнении запроса: " + error);
    }
  });

}

function ChangeFuncEmployee(button,option)
{

  var ID = $(button).data('id');
  var name = document.getElementById("name1").value;
  var lastname = document.getElementById("lastname1").value;
  var phone = document.getElementById("phone1").value;
  var email = document.getElementById("email1").value;
  var type = document.getElementById("accessLevel1").value;
  console.log(name);

  if (name || lastname || phone || email || type) {
    // Все поля заполнены, выполните AJAX-запрос
    $.ajax({
      url: 'Sotrud.php',
      type: 'POST',
      data: {
        id: ID,
        name:name,
        lastname: lastname,
        email: email,
        phone:phone,
        type: type,
        option:option
      },
      success: function () {
        
        // После успешной отправки, закройте модальное окно
        closeModal2();
        location.reload();
      },
      error: function (error) {
        console.error("Ошибка при выполнении запроса: " + error);
      }
    });
  } else {
    alert("Вы ничего не изменили");
  }

}
function deleteEmployee(button,option)
{
  var ID = $(button).data('id');
  $.ajax({
    url: 'Sotrud.php',
    type: 'POST',
    data: {
      option:option,
      id: ID
    },
    success: function () {
      console.log("Успешно удалено!");
      location.reload();
    },
    error: function (error) {
      console.error("Ошибка при выполнении запроса: " + error);
    }
  });

}

//----------------------------------------Код для страница ОБОРУДОВАНИЕ-------------------------
//Открыть Тех. док.
function OpenTechFile(path) 
{
  var docPath ='..' + path;
  window.open(docPath, '_blank');
  console.log(docPath);
}

function addEquip() {
  document.getElementById("myModal").style.display = "block";
}
function closeModal() {
  document.getElementById("myModal").style.display = "none";
}
function closeModal2() {
  document.getElementById("myModal2").style.display = "none";
}

function addNewEquip(option) {
  var name = document.getElementById("name").value;
  var serial = document.getElementById("serial").value;
  var depart = document.getElementById("depart").value;
  var file_data = $('#doc').prop('files')[0];
  var form_data = new FormData();

  form_data.append('option', option);
  form_data.append('name', name);
  form_data.append('serial', serial);
  form_data.append('depart', depart);
  form_data.append('doc', file_data);

  if (name && serial && depart && file_data) {
      $.ajax({
          url: 'Equip.php',
          type: 'POST',
          data: form_data,
          contentType: false,
          processData: false,
          cache: false,
          success: function (response) {
              console.log(response);
              closeModal2();
              location.reload();
          },
          error: function (error) {
              console.error("Ошибка при выполнении запроса: " + error);
          }
      });
  } else {
      alert("Пожалуйста, заполните все поля.");
  }
}


function changeEquip(button,option)
{
  document.getElementById("myModal2").style.display = "block";
  var ID = $(button).data('id');
  console.log(ID);
  // Задаем айдишник в data-id для кнопки изменения
  $('#myModal2 .bttnAddNewEquip').attr('data-id', ID);

  $.ajax({
    url: 'Equip.php',
    type: 'POST',
    data: {
      option:option,
      id: ID
    },
    success: function(data) {
      console.log(data);
      // Разбираем JSON-строку
      var parsedData = JSON.parse(data);
      
      // Обновляем содержимое contentContainer полученными данными
      $('.modal2 #name1').val(parsedData.name);
      $('.modal2 #serial1').val(parsedData.serial);
      $('.modal2 #depart1').val(parsedData.depart);
      console.log(parsedData.doc);
      
    },
    error: function(error) {
      console.error("Ошибка при выполнении запроса: " + error);
    }
  });

}

function ChangeFuncEquip(button,option)
{

  var ID = $(button).data('id');
  var name = document.getElementById("name1").value;
  var serial = document.getElementById("serial1").value;
  var depart = document.getElementById("depart1").value;
  var file_data = $('#doc1').prop('files')[0];
  var form_data = new FormData();

  form_data.append('id', ID);
  form_data.append('option', option);
  form_data.append('name', name);
  form_data.append('serial', serial);
  form_data.append('depart', depart);
  form_data.append('doc', file_data);

  console.log(file_data);

  var fileInput = document.getElementById('doc1'); // Замените 'doc1' на ваш ID элемента input
  var file = fileInput.files[0];



  if (name && serial && depart) {
    // Все поля заполнены, выполните AJAX-запрос
    $.ajax({
      url: 'Equip.php',
      type: 'POST',
      data: form_data,
      contentType: false,
      processData: false,
      cache: false,
      success: function (data) {
        
        if (file) {
          // Файл был выбран, выполните необходимые действия
          console.log('Файл загружен:', data);
        } else {
          // Файл не был выбран
          console.log('Файл не загружен');
      }
        // После успешной отправки, закройте модальное окно
        closeModal2();
        location.reload();
      },
      error: function (error) {
        console.error("Ошибка при выполнении запроса: " + error);
      }
    });
  } 
  else {
    alert("Вы ничего не изменили");
  }

}
function deleteEquip(button,option)
{
  var ID = $(button).data('id');
  $.ajax({
    url: 'Equip.php',
    type: 'POST',
    data: {
      option:option,
      id: ID
    },
    success: function () {
      console.log("Успешно удалено! ");
      location.reload();
    },
    error: function (error) {
      console.error("Ошибка при выполнении запроса: " + error);
    }
  });

}