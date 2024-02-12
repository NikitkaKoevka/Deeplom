<?php
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
$firstName = $_POST['fname'];
$lastName = $_POST['lname'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$theme = $_POST['theme'];
$equipment = $_POST['equip'];
$content = strip_tags($_POST['content']);

// Проверка, существует ли пользователь с указанной почтой
$sql = "SELECT * FROM user WHERE email = '$email'";
$rrr='/photos/IMG_8009.jpg';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Пользователь уже существует, записываем данные заявки в таблицу request
    $row = $result->fetch_assoc();
    $userId = $row['ID'];

    // Получение текущей даты и времени
    $creationDate = date('Y-m-d H:i:s');

    // Запись данных заявки в таблицу request
    $sql = "INSERT INTO request (Request_owner, Request_theme, Request_equip, Request_content, CreationDate) 
            VALUES ('$userId', '$theme', '$equipment', '$content', '$creationDate')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Заявка успешно создана');</script>";
        $requestId = $conn->insert_id; // Получаем ID только что созданной заявки

        // Создание новой беседы (conversation)
        $sql = "INSERT INTO conversations (ID,user_id1, user_id2) VALUES ('$requestId','$userId', NULL)"; // NULL - ID администратора, с которым будет беседа

        if ($conn->query($sql) === TRUE) {
            $conversationId = $conn->insert_id; // Получаем ID только что созданной беседы

            // Создание первого сообщения
            $senderId = $userId; // ID отправителя (пользователя)
            $messageText = $content; // Текст сообщения

            // Получение текущей даты и времени
            $timestamp = date('Y-m-d H:i:s');

            // Запись первого сообщения в таблицу messages
            $sql = "INSERT INTO messages (type,conversation_id, sender_id, message_text, timestamp)
                    VALUES (0,'$conversationId', '$senderId', '$messageText', '$timestamp')";

            if ($conn->query($sql) === TRUE) {
                // Сообщение успешно добавлено
                $conn->close();
                header("Location: Страница подачи заявки.html");
                exit();
            } else {
                echo "<script>alert('Ошибка при создании сообщения: " . $conn->error . "');</script>";
                $conn->close();
                header("Location: Страница подачи заявки.html");
                exit();
            }
        } else {
            echo "<script>alert('Ошибка при создании беседы: " . $conn->error . "');</script>";
            $conn->close();
            header("Location: Страница входа.html");
            exit();
        }
    } else {
        echo "<script>alert('Ошибка при создании заявки: " . $conn->error . "');</script>";
        $conn->close();
        header("Location: Страница подачи заявки.html");
        exit();
    }
} else {

    // Создание нового пользователя
    
    $sql = "INSERT INTO user (ID, name, lastname, email, phone, usertype, password, photolink) 
    VALUES (NULL, '$firstName', '$lastName', '$email', '$phone', '1', '', NULL)";

    if ($conn->query($sql) === TRUE) {
        // Получение ID только что созданного пользователя
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $userId = $row['ID'];
        // Получение текущей даты и времени
        $creationDate = date('Y-m-d H:i:s');

        // Запись данных заявки в таблицу request
        $sql = "INSERT INTO request (Request_owner, Request_theme, Request_equip, Request_content, CreationDate) 
            VALUES ('$userId', '$theme', '$equipment', '$content', '$creationDate')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Заявка успешно создана');</script>";
            $requestId = $conn->insert_id; // Получаем ID только что созданной заявки

            // Создание новой беседы (conversation)
            $sql = "INSERT INTO conversations (ID, user_id1, user_id2) VALUES ($requestId,'$userId', NULL)"; // NULL - ID администратора, с которым будет беседа

            if ($conn->query($sql) === TRUE) {
                $conversationId = $conn->insert_id; // Получаем ID только что созданной беседы

                // Создание первого сообщения
                $senderId = $userId; // ID отправителя (пользователя)
                $messageText = $content; // Текст сообщения

                // Получение текущей даты и времени
                $timestamp = date('Y-m-d H:i:s');

                // Запись первого сообщения в таблицу messages
                $sql = "INSERT INTO messages (type,conversation_id, sender_id, message_text, timestamp)
                VALUES (0,'$conversationId', '$senderId', '$messageText', '$timestamp')";

                if ($conn->query($sql) === TRUE) {
                    // Сообщение успешно добавлено
                    $conn->close();
                    header("Location: Страница подачи заявки.html");
                    exit();
                } else {
                    echo "<script>alert('Ошибка при создании сообщения: " . $conn->error . "');</script>";
                    $conn->close();
                    header("Location: Страница подачи заявки.html");
                    exit();
                }
            } else {
                echo "<script>alert('Ошибка при создании беседы: " . $conn->error . "');</script>";
                $conn->close();
                header("Location: Страница подачи заявки.html");
                exit();
            }
        } else {
            echo '<script>alert("Ошибка при создании заявки: ' .  $conn->error . '");</script>';
            $conn->close();
            header("Location: Страница входа.html");
            exit();
        }
    } else {
        echo '<script>alert("Ошибка при создании заявки: ' .  $conn->error . '");</script>';
        $conn->close();
        echo '<script>window.location.href = "Страница подачи заявки.html";</script>'; // 1 секунда
        exit();
    }
}



?>
