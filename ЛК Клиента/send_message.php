<?php
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";
$message=$_POST['message'];
$conn = new mysqli($servername, $username, $password, $dbname);

$conversation_id= $_COOKIE['conversation_id'];
$creationDate = date('Y-m-d H:i:s');
$idd = $_COOKIE['ID'];
$sql = "INSERT INTO messages (ID, conversation_id, sender_id, message_text, timestamp) VALUES (NULL, '$conversation_id', '$idd', '$message', '$creationDate')";

$result1 = $conn->query($sql);

?>
