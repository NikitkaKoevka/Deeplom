<?php
session_start();
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);

$idd = $_SESSION['UserID'];


$currentYear = date('Y');

// Запрос к базе данных для получения количества завершенных заявок по месяцам за текущий год
$sql = "SELECT MONTH(FinnishDate) as month, COUNT(*) as count 
        FROM request 
        WHERE Request_response = $idd 
        AND Request_status = 'Завершено' 
        AND YEAR(FinnishDate) = $currentYear
        GROUP BY MONTH(FinnishDate)";

$result = $conn->query($sql);


$completedRequestsData = array_fill(1, 12, 0);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $completedRequestsData[$row['month']] = $row['count'];
    }

        // Закрываем соединение с базой данных
    $conn->close();

    echo json_encode(array_values($completedRequestsData));
}

else
echo "(((";


?>