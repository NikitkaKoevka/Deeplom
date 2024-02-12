<?php
session_start();
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);

$conversationId = $_POST['conversation_id'];
$rating = $_POST['rating'];

$sql = "UPDATE request SET mark = $rating WHERE ID = $conversationId";

if($conn->query($sql) === TRUE)
{
    echo "Успех";
}
else
{
    echo "Не удалось оценить";
}


?>