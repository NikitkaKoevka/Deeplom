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
$email = $_POST['email'];
$password = $_POST['password'];
$password1= (md5($password));
// Проверка, существует ли пользователь с указанной почтой
$sql = "SELECT * FROM user WHERE email = '$email' AND password='$password1'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Пользователь существует
    $row = $result->fetch_array();
    if($row['usertype']==1)
    {
        //setcookie("ID", $row['ID'],0,"/");
    
        $userId = $row['ID'];
        //$firstname = $row['name'];
        //$lastname = $row['lastname'];
        //$foto=$row['photolink'];
    
            session_start();
            //$_SESSION['photo']=$foto;
            $_SESSION['logged_in']=1;
            $_SESSION['UserID']=$userId;
            //$_SESSION['first_name'] = $firstname;
            //$_SESSION['last_name'] = $lastname; 
            $conn->close();
            header("Location: \ЛК Клиента\ЛК1.html.php");
            exit();
    }
    else if($row['usertype']==2)
    {
        //setcookie("ID", $row['ID'],0,"/");
    
        $userId = $row['ID'];
        //$firstname = $row['name'];
        //$lastname = $row['lastname'];
        //$foto=$row['photolink'];
        
            session_start();
            //$_SESSION['photo']=$foto;
            $_SESSION['logged_in']=2;
            $_SESSION['UserID']=$userId;
            //$_SESSION['first_name'] = $firstname;
            //$_SESSION['last_name'] = $lastname; 
            $conn->close();
            header("Location: \ЛК Сотрудника\Заявки.html.php");
            exit();
    }
    else if($row['usertype']==3)
    {
        //setcookie("ID", $row['ID'],0,"/");
    
        $userId = $row['ID'];
        //$firstname = $row['name'];
        //$lastname = $row['lastname'];
        //$foto=$row['photolink'];
    
            session_start();
            //$_SESSION['photo']=$foto;
            $_SESSION['logged_in']=3;
            $_SESSION['UserID']=$userId;
            //$_SESSION['first_name'] = $firstname;
            //$_SESSION['last_name'] = $lastname; 
            $conn->close();
            header("Location: \ЛК Сотрудника\Заявки.html.php");
            exit();
    }
    }
    else {
   
        echo '<script>alert("Ошибка при входе: ' .  $conn->error . '");</script>';
        echo '<script>window.location.href = "Страница входа.html";</script>'; 
        $conn->close();
        exit();
    }


        
?>
