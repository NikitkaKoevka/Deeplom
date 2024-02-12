<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}
$name = $_POST["name"];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$phone= $_POST['phone'];
$id=$_POST['id'];
$type=$_POST['type'];
$option = $_POST['option'];
$password= (md5('qwerty'));
$photolink= "/photos/man-silhouette.jpg";
switch($option)
{
    //Создаем нового сотрудника
    
    case 'Create':
        {
            $query = "INSERT INTO user (ID, name, lastname, email, phone, usertype, password, photolink) 
            VALUES (NULL, '$name', '$lastname', '$email','$phone','$type','$password','$photolink')";

            if ($conn->query($query) === TRUE) 
            {
                echo '<script>window.location = "База знаний.html.php";</script>';
                exit();
            } else 
            {
                echo '<script>alert("Ошибка при создании FAQ: ' .  $conn->error . '");</script>';
                exit();
            }
        }
    break;
    
    //Показываем окно для изменения FAQ
    case 'Change':
        {
            $query = "SELECT * FROM user WHERE ID = $id";
            $result = $conn->query($query);
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        
                // Создаем ассоциативный массив с данными
                $data = array(
                    'name' => $row['name'],
                    'lastname' => $row['lastname'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'type' => $row['usertype']
                );
        
                // Преобразуем массив в JSON и возвращаем его
                echo json_encode($data);
            } else {
                echo "Ошибка.";
            }
        }
        break;
    //Изменяем FAQ
    case 'ChangeFunc':
        {
            $query = "UPDATE user SET name = '$name', lastname = '$lastname', usertype = '$type', email='$email', phone='$phone' WHERE ID = $id";

            if ($conn->query($query) === TRUE) 
            {
                exit();
            } else 
            {
                echo '<script>alert("Ошибка при создании FAQ: ' .  $conn->error . '");</script>';;
                exit();
            }
        }
    break;
    //Удаляем FAQ
    case 'Delete':
        {
            $query = "DELETE FROM user WHERE ID = $id";
            
            if ($conn->query($query) === TRUE) 
            {
                exit();
            } else 
            {
                echo '<script>alert("Ошибка при удалении FAQ: ' .  $conn->error . '");</script>';;
                exit();
            }
        }
    break;

}



?>
