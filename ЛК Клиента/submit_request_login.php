<?php
session_start();
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

    // Получение данных из POST-запроса
    $idd = $_SESSION['UserID'];
    $theme = $_POST['theme'];
    $equipment = $_POST['equip'];
    $content = strip_tags($_POST['description']);

    // Получение текущей даты и времени
    $creationDate = date('Y-m-d H:i:s');

    // Запись данных заявки в таблицу request
    $sql = "INSERT INTO request (Request_owner, Request_theme, Request_equip, Request_content, CreationDate) 
            VALUES ('$idd', '$theme', '$equipment', '$content', '$creationDate')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Заявка успешно создана');</script>";
        $requestId = $conn->insert_id; // Получаем ID только что созданной заявки

        // Создание новой беседы (conversation)
        $sql = "INSERT INTO conversations (ID,user_id1, user_id2) VALUES ('$requestId','$idd', NULL)"; // NULL - ID администратора, с которым будет беседа

        if ($conn->query($sql) === TRUE) 
        {
            $conversationId = $conn->insert_id; // Получаем ID только что созданной беседы
            // Создание первого сообщения
            $senderId = $idd; // ID отправителя (пользователя)
            $messageText = $content; // Текст сообщения
            // Получение текущей даты и времени
            $timestamp = date('Y-m-d H:i:s');
            // Запись первого сообщения в таблицу messages
            $sql = "INSERT INTO messages (type,conversation_id, sender_id, message_text, timestamp)
                    VALUES (0,'$conversationId', '$senderId', '$messageText', '$timestamp')";

            if ($conn->query($sql) === TRUE) {
                // Сообщение успешно добавлено
                $conn->close();
                $i=1;
                setcookie("i",$i,time()+5,"/");
                header("Location: ЛКПодатьЗаявку.html.php");
                exit();
            } else {
                $conn->close();
                $i=2;
                setcookie("i",$i,time()+5,"/");
                header("Location: ЛКПодатьЗаявку.html.php");
                exit();
            }
        } else {
            $conn->close();
            $i=3;
            setcookie("i",$i,time()+5,"/");
            header("Location: ЛКПодатьЗаявку.html.php");
            exit();
        }
    } 
    else 
    {
        echo '<script>alert(\'' . $_SESSION['UserID'] . '\');</script>';

        $conn->close();
        $i=4;
        setcookie("i",$i,time()+5,"/");
        //header("Location: ЛКПодатьЗаявку.html.php");
        exit();
    }



$conn->close();
exit();
?>
