<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}


$idd = $_SESSION['UserID'];

if($_POST['stage']==0)
{
    // Получение данных из формы
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $pw = $_POST['pw'];

    // Подготовка данных для запроса
    $updateString = '';

    if (!empty($name)) {
        $updateString .= "name = '$name', ";
    }

    if (!empty($lastname)) {
        $updateString .= "lastname = '$lastname', ";
    }

    if (!empty($email)) {
        $updateString .= "email = '$email', ";
    }

    $updateString = rtrim($updateString, ', ');


    // Проверка наличия данных для вставки
    if (!empty($updateString)) 
    {
        
        // Запись данных в базу данных
        $sql = "UPDATE user SET $updateString WHERE ID = $idd";

        if ($conn->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Все поля пустые";
    }


    if (!empty($pw)) {

        $rand= rand(1111, 9999);
        require '../vendor/phpmailer/phpmailer/src/Exception.php';
        require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require '../vendor/phpmailer/phpmailer/src/SMTP.php';
        require '../vendor/autoload.php';
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.mail.ru';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'alumna.tech@mail.ru';                     //SMTP username
            $mail->Password   = 'S9ejkyKPjZuWenZRH5dM';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet    = 'UTF-8';  
            //Recipients
            $mail->setFrom('alumna.tech@mail.ru', 'Alumna Tech');
            $mail->addAddress($email, $name.''.$lastname);     //Add a recipient


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Код '.$rand;
            $mail->Body    = 'Ваш код для смены пароля <b>'.$rand.'</b>';
            $mail->AltBody = 'Ваш код для смены пароля - '.$rand;

            $mail->send();
            echo $rand;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
    }
else
{
    $pw = $_POST['pw'];
    $updateString = '';
    $updateString .= "password = '".md5($pw)."'";
    $sql = "UPDATE user SET $updateString WHERE ID = $idd";

        if ($conn->query($sql) === TRUE) 
        {
            echo 'успех';
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

}

$conn->close();
?>