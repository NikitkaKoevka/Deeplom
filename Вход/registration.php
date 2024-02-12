<?php
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Получение данных из POST-запроса
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$password1= (md5($password));

// Проверка, существует ли пользователь с указанной почтой
$sql = "SELECT * FROM user WHERE email = '$email'";
$result = $conn->query($sql);
$foto='/photos/man-silhouette.jpg';
if ($result->num_rows > 0) 
{
    // Пользователь уже существует, записываем данные заявки в таблицу user
    $row = $result->fetch_assoc();
    $userId = $row['ID'];
    // Запись данных заявки в таблицу request
    $sql = "UPDATE user SET password = '$password1', photolink = '$foto' WHERE user.ID = '$userId'";

    if ($conn->query($sql) === TRUE) 
    {
        echo "<script>alert('Вы были зарегистрированы');</script>";
        session_start();

        $_SESSION['UserID']=$userId;
        $_SESSION['logged_in']=1;

        $conn->close();
        header("Location: \ЛК Клиента\ЛК1.html.php");
        exit();
    } else 
    {
        echo '<script>alert("Ошибка при регистрации пользователя: ' .  $conn->error . '");</script>';
        echo '<script>window.location.href = "Страница регистрации.html";</script>'; 
        $conn->close();
        exit();
    }
} 
else 
{
   
    // Создание нового пользователя
    $sql = "INSERT INTO user (ID, name, lastname, phone, email, password, usertype, photolink) 
            VALUES (NULL, '$firstname', '$lastname', '$phone', '$email','$password1','1','$foto')";
    
    if ($conn->query($sql) === TRUE) 
    {
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = $conn->query($sql);
        $row = $result->fetch_array();
        $userId = $row['ID'];
        session_start();
        
        $_SESSION['UserID']=$userId;
        $_SESSION['logged_in']=1;
        $conn->close();
        header("Location: \ЛК Клиента\ЛК1.html.php");
        exit();
    } else 
    {
        echo '<script>alert("Ошибка при регистрации пользователя: ' .  $conn->error . '");</script>';
        echo '<script>window.location.href = "Страница регистрации.html";</script>'; 
        $conn->close();
        exit();
    }

}

?>
