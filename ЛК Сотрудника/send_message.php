<?php
// Подключение к базе данных
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";
$message=$_POST['message'];
$conn = new mysqli($servername, $username, $password, $dbname);

$conversation_id= $_COOKIE['conversation_id'];
$creationDate = date('Y-m-d H:i:s');
$idd = $_SESSION['UserID'];
$sql = "INSERT INTO messages (ID, type, conversation_id, sender_id, message_text, timestamp) VALUES (NULL, 0, '$conversation_id', '$idd', '$message', '$creationDate')";

$result1 = $conn->query($sql);

?>
