<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="ЛКПодатьЗаявку.css">
    <link rel="icon" href="ISTOK.ico">
    <title>Личный кабинет</title>
    <?php
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 1) {
        // если пользователь не вошел в систему, перенаправляем на страницу логина
        session_destroy();
        header("Location: ../Вход/Страница входа.html");
        exit();
    }

            // Подключение к базе данных
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "istok";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $userID=$_SESSION['UserID'];

    $sql = "SELECT * FROM user WHERE ID = '$userID'";
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    $firstName= $row['name'];
    $lastName= $row['lastname'];
    $photo= $row['photolink'];

    $sql = "SELECT * FROM conversations WHERE ID = '$conversation_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    $conId = $row['ID']; 

    ?>


</head>

<body>
<form class="bbody" id="Entry" method="post">

        <div class="container">
            <div class="Application">
                <div class="bttnback">
                    <a  href="ЛК1.html.php">
                        <img class="sendback"src="../icons/SendBack.svg" alt="<">
                    </a>
                </div>
            <div class="AppData">
                <div class="Theme">
                    <label  for="theme">Тема обращения:</label>
                    <input name="theme" type="text" class="theme">
                </div>
                <div class="Equip">
                    <label  for="equip">Оборудование:</label>
                    <input name="equip" type="text" class="equip">
                </div>
                <div class="Descrip">
                    <label  for="description">Описание обращения:</label>
                    <textarea name="description" type="textarea" class="description"></textarea>
                </div>
            </div>
            </div>
            <div class="profile">
                <div>
                <div class="avajp">
                <img src="<?php echo $photo;?>" alt="ava" class="avatarka">
                </div>
                <div class="info">
                    <p id="Fname" style="font-weight:600"><?php echo $firstName; ?></p>
                    <p id="Sname" style="font-weight:600"><?php echo $lastName; ?></p>
                </div>
                </div>
                
                <div class="bttns">
                    <button onclick=submitForm()  class="CreateApplication">подать заявление</button>
                    <button onclick=logOutForm() class="LogOut">Выйти</button>
                </div>
            </div>
        </div>

</form>
<div id="i1">Сохранено</div>
<div id="i2">Ошибка при создании сообщения: </div>
<div id="i3">Ошибка при создании беседы: </div>
<div id="i4">Ошибка при создании заявки: </div>
</body>
<script>
    function submitForm() 
{
        var form = document.getElementById("Entry");
        form.action = "submit_request_login.php";
        form.submit();
}
function logOutForm() 
{
        var form = document.getElementById("Entry");
        form.action = "../Вход/LogOut.php";
        form.submit();
}
  var i = document.cookie.match('(^|;)\\s*i\\s*=\\s*([^;]+)').pop();
  if(i == 1) {
    document.getElementById("i1").style.display = "block";
    setTimeout(function() {
        document.getElementById("i1").style.display = "none";
    }, 3000);
    }else if(i == 2) {
        document.getElementById("i2").style.display = "block";
    setTimeout(function() {
        document.getElementById("i2").style.display = "none";
    }, 3000);
    }else if(i == 3) {
        document.getElementById("i3").style.display = "block";
    setTimeout(function() {
        document.getElementById("i3").style.display = "none";
    }, 3000);
    }
    else if(i == 4) {
        document.getElementById("i4").style.display = "block";
    setTimeout(function() {
        document.getElementById("i4").style.display = "none";
    }, 3000);
    }
</script>

</html>
