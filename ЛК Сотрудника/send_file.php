<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}
$conversation_id= $_COOKIE['conversation_id'];
$creationDate = date('Y-m-d H:i:s');
$creationDateWithoutColon = str_replace(":", "_", $creationDate);
$file = $_FILES["doc"];
$targetDirectory = 'C:/ospanel/domains/Deeplom/mess_photos/';
$newFileName = $conversation_id . "_" . $creationDateWithoutColon . "IMG"; // Создаем новое имя файла (например, имя + текущее время)



// Проверка типа файла
$imageType = exif_imagetype($file['tmp_name']);
if ($imageType === IMAGETYPE_JPEG) {
    $newFileName .= ".jpg";
} elseif ($imageType === IMAGETYPE_PNG) {
    $newFileName .= ".png";
} else {
    die("Недопустимый тип файла. Поддерживаются только JPEG и PNG.");
}
$targetFile = $targetDirectory . basename($newFileName);

            // Перемещение файла в целевую директорию
            if (move_uploaded_file($file["tmp_name"], $targetFile)) 
            {
                echo "Файл успешно загружен и перемещен!";
            } 
            else 
            {
                echo "Файл не удалось переместить!";
            }


$idd = $_SESSION['UserID'];
$message = "/mess_photos/" . $newFileName;
$sql = "INSERT INTO messages (ID, type, conversation_id, sender_id, message_text, timestamp) VALUES (NULL, 1, '$conversation_id', '$idd', '$message', '$creationDate')";

$result1 = $conn->query($sql);
echo $creationDateWithoutColon;
?>