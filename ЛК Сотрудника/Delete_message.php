<?php
session_start();
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);

$mess_id= $_POST['messageId'];
$sql = "SELECT * FROM messages WHERE ID = '$mess_id'";
$result1 = $conn->query($sql);
$row = $result1->fetch_assoc();
if ($result1->num_rows > 0 && $row['type']==1) 
            {
            
            $targetDirectory = 'C:/ospanel/domains/Deeplom';
            $oldFilePath = $targetDirectory . $row['message_text'] ; 
            if (file_exists($oldFilePath)) 
            {
                unlink($oldFilePath);
            }
            }

$sql = "DELETE FROM messages WHERE ID = '$mess_id'";
$result2 = $conn->query($sql);

if($conn->query($sql) === TRUE)
{
    echo "Успех";
}
else
{
    echo "Не удалось удалить сообщение";
}


?>