<?php
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);

$conversation_id= $_COOKIE['conversation_id'];


$sql = "SELECT * FROM messages WHERE conversation_id = '$conversation_id' ORDER BY timestamp";
$result1 = $conn->query($sql);

$idd = $_COOKIE['ID'];

while($row1 = $result1->fetch_array())
{

    if($row1['sender_id']==$idd)
    {
        echo "<div class='mess right'>".$row1['message_text']."<div class='datee'>".date('H:i', strtotime($row1['timestamp']))."</div></div>";
    }
    else
    {
        echo "<div class='mess left '>".$row1['message_text']."<div class='datee'>".date('H:i', strtotime($row1['timestamp']))."</div></div>";
    }

}

?>
