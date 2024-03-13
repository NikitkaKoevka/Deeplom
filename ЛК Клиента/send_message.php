<?php
    session_start();
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";
$message=$_POST['message'];
$conn = new mysqli($servername, $username, $password, $dbname);

$conversation_id= $_POST['conversation_id'];
$creationDate = date('Y-m-d H:i:s');
$userID=$_SESSION['UserID'];
$sql = "INSERT INTO messages (ID, type,conversation_id, sender_id, message_text, timestamp) VALUES (NULL, 0,'$conversation_id', '$userID', '$message', '$creationDate')";

$result1 = $conn->query($sql);

?>
