<?php
session_start();
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);

$idd = $_SESSION['UserID'];

$sql = "SELECT Request_status FROM request WHERE Request_response = $idd";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// Формирование массива
$statsArray = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $statsArray[] = $row['Request_status'];
    }
    $countArray = array('В процессе' => 0, 'Завершено' => 0);

    // Проходим по исходному массиву и увеличиваем соответствующее значение в $countArray
    foreach ($statsArray as $value) {
        $countArray[$value]++;
    }

    // Создаем новый массив с подсчитанными значениями
    $resultArray = array($countArray['В процессе'], $countArray['Завершено']);

// Закрываем соединение с базой данных
$conn->close();

echo json_encode($resultArray);



}
else
echo "(((";


?>