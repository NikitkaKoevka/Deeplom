<?php
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);

$email=$_POST['email'];
$respon=$_POST['respon'];
$watcher=$_POST['watcher'];
$statusi=$_POST['statusi'];
$processing=$_POST['processing'];
$idd = $_COOKIE['conversation_id'];

if($statusi=='Обработка'){
    $creationDate = date('Y-m-d H:i:s');
    $sql = "UPDATE request SET Request_response='$respon', Request_viewer='$watcher', Request_status='$statusi', PlanDate='$processing', Start_time='$creationDate' WHERE ID='$idd'";
    $result = $conn->query($sql);

    $sql1 = "UPDATE conversations SET user_id2='$respon' WHERE ID='$idd'";
    $result1 = $conn->query($sql1);
}else if($statusi=='Завершено'){
    $creationDate = date('Y-m-d H:i:s');
    $sql = "UPDATE request SET Request_response='$respon', Request_viewer='$watcher', Request_status='$statusi', PlanDate='$processing', FinnishDate='$creationDate' WHERE ID='$idd'";
    $result = $conn->query($sql);

    $sql1 = "UPDATE conversations SET user_id2='$respon' WHERE ID='$idd'";
    $result1 = $conn->query($sql1);
}else{
    $sql = "UPDATE request SET Request_response='$respon', Request_viewer='$watcher', Request_status='$statusi', PlanDate='$processing' WHERE ID='$idd'";
    $result = $conn->query($sql);

    $sql1 = "UPDATE conversations SET user_id2='$respon' WHERE ID='$idd'";
    $result1 = $conn->query($sql1);
}




?>