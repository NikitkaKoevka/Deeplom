<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="ЛК1переписка.css">
    <link rel="icon" href="ISTOK.ico">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
    if ($conn->connect_error) 
    {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }
    $userID=$_SESSION['UserID'];
    $sql = "SELECT * FROM user WHERE ID = '$userID'";
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    $firstName= $row['name'];
    $lastName= $row['lastname'];
    $photo= $row['photolink'];

    
    $conversation_id = $_POST['conversation_id'];
    setcookie("conversation_id", $conversation_id,0,"/");
    $sql = "SELECT * FROM conversations WHERE ID = '$conversation_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    $conId = $row['ID']; 

    $sql2 = "SELECT * FROM request WHERE ID = '$conversation_id'";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_array();
    $obr = $row2['Request_response'];
    $stat = $row2['Request_status'];

    $sql3 = "SELECT * FROM user WHERE ID = '$obr'";
    $result3 = $conn->query($sql3);
    $row3 = $result3->fetch_array();
    $sotrud = $row3['name'];
    ?>
</head>
<body>
    <div class="container">
        
        <div id='contextMenu'>
                <button id='deleteMessage' class='delete' onclick="deleteMessage()">
                    <img src='../icons/Delete.svg' width='25px' alt='?'>
                </button>
        </div>

        <div class="messenger">
            <div class="messheader">
            <a  href="ЛК1.html.php">
                <img class="sendback" src="../icons/SendBack.svg" alt="<">
            </a>

                <div class="SV">
                    Заявление №
                    <p id="NumberApplic"><?php echo $conversation_id; ?></p>
                </div>
                <div class="SV">
                    Статус:
                    <p id="Stattype"><?php echo $stat; ?></p>
                </div>
                <div class="SV">
                    Сотрудник:
                    <p id="name"><?php echo $sotrud; ?></p>
                </div>
            </div>

            <div id="messages">

            </div>
            <form id="chat-form" enctype='multipart/form-data'>
            <div class="sendmess">
                <textarea id="chat-message" cols="30" rows="10" class="typetext" placeholder="Напишите сообщение"></textarea>
                <label for="paperclip">
                    <img src="../icons/скрепка.svg" alt="p" class="paperclip">
                </label>
                <input accept='image/jpeg, image/png' id="paperclip" type="file" >
                <button class="send"><img src='../icons/Send.svg' alt='p' class='sendpic' ></button>
           </div>
           </form>
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
                
            </div>
        </div>
    </div>

</body>
<script src="chat.js"></script>
</html>