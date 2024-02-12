<?php
session_start();
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);

$idd = $_SESSION['UserID'];

$sql = "SELECT mark FROM request WHERE Request_response = $idd AND mark IS NOT NULL";
$result = $conn->query($sql);

// Формирование массива с оценками
$marksArray = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $marksArray[] = $row['mark'];
    }
}
// Создание массива с нулями для каждой оценки от 5 до 1
$countArray = array(0, 0, 0, 0, 0);

// Подсчет количества каждой оценки
foreach ($marksArray as $value) {
    $countArray[$value - 1]++;
}
$resultArray = array($countArray[0], $countArray[1], $countArray[2], $countArray[3], $countArray[4]);

// Закрываем соединение с базой данных
$conn->close();

echo json_encode($resultArray);
?>