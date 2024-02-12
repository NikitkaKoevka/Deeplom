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
$serial = $_POST['serial'];
$depart = $_POST['depart'];
$option=$_POST['option'];
$id = $_POST['id'];

switch($option)
{
    //Создаем новое оборудование
    
    case 'Create':
        {
            // Получаем данные о файле
            $file = $_FILES["doc"];
        
            $targetDirectory = 'C:/ospanel/domains/Deeplom/equipment/';
            $newFileName = $_POST["name"] . ".pdf" ; // Создаем новое имя файла 
            $targetFile = $targetDirectory . basename($newFileName);
            
            // Перемещение файла в целевую директорию
            if (move_uploaded_file($file["tmp_name"], $targetFile)) 
            {
                echo "Файл успешно загружен и перемещен!";
                
                $fileUrl = '/equipment/' . basename($newFileName); // Путь к файлу в базе данных
                $sql = "INSERT INTO equipment (name, serial, depart, doc) VALUES ('$name', '$serial', '$depart', '$fileUrl')";
                
                if ($conn->query($sql) === TRUE) {
                    echo "Данные успешно добавлены в базу данных!";
                } else {
                    echo "Ошибка при добавлении данных в базу данных: " . $conn->error;
                }
            } else {
                echo "Файл не удалось переместить!";
            }

        } 
    break;

    //Показываем окно для изменения оборудования
    case 'Change':
        {
            $query = "SELECT * FROM equipment WHERE ID = $id";
            $result = $conn->query($query);
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        
                // Создаем ассоциативный массив с данными
                $data = array(
                    'name' => $row['name'],
                    'serial' => $row['serial'],
                    'depart' => $row['depart'],
                    'doc' => $row['doc']
                );
        
                // Преобразуем массив в JSON и возвращаем его
                echo json_encode($data);
            } else {
                echo "Ошибка.";
            }
        }
        break;
    //Изменяем оборудование
    case 'ChangeFunc':
        {   
            $file = $_FILES["doc"];
            
            if($file==0)
            {   
                $docUpdate = '/equipment/' . $name . '.pdf';

                $query = "SELECT * FROM equipment WHERE ID = $id";
                $result = $conn->query($query);

                if ($result->num_rows > 0) 
                {
                    $row = $result->fetch_assoc();
                    $oldFileName = $row['name'] . '.pdf';
                }

                $query = "UPDATE equipment SET name = '$name', serial = '$serial', depart = '$depart', doc = '$docUpdate' WHERE ID = $id";

                if ($conn->query($query) === TRUE) 
                {
                    $newFileName = $name . '.pdf'; // Замените на новое имя файла

                    // Путь к текущему файлу
                    $oldFilePath = 'C:/ospanel/domains/Deeplom/equipment/' . $oldFileName;

                    // Путь к новому файлу
                    $newFilePath = 'C:/ospanel/domains/Deeplom/equipment/' . $newFileName;

                    // Переименование файла
                    if (rename($oldFilePath, $newFilePath)) {
                        echo "Файл успешно переименован!";
                    } else {
                        echo "Ошибка при переименовании файла!";
                    }
                    exit();
                } else 
                {
                    echo '<script>alert("Ошибка при создании FAQ: ' .  $conn->error . '");</script>';;
                    exit();
                }
            }
            else
            {
                $targetDirectory = 'C:/ospanel/domains/Deeplom/equipment/';
                $newFileName = $_POST["name"] . ".pdf" ; // Создаем новое имя файла (например, имя + pdf)
                $targetFile = $targetDirectory . basename($newFileName);

                $query = "SELECT * FROM equipment WHERE ID = $id";
                $result = $conn->query($query);

                if ($result->num_rows > 0) 
                {
                    $row = $result->fetch_assoc();
                }

                // Проверяем, существует ли старый файл, и если да, удаляем его
                $oldFilePath = $targetDirectory . $row['name'] . '.pdf'; 
                if (file_exists($oldFilePath)) 
                {
                    unlink($oldFilePath);
                }
                                // Перемещение файла в целевую директорию
                    if (move_uploaded_file($file["tmp_name"], $targetFile)) 
                    {
                        echo "Файл успешно загружен и перемещен!";
                        
                        $fileUrl = '/equipment/' . basename($newFileName); // Путь к файлу в базе данных
                        $sql = "UPDATE equipment SET name = '$name', serial = '$serial', depart = '$depart', doc = '$fileUrl' WHERE ID = $id";
                        
                        if ($conn->query($sql) === TRUE) {
                            echo "Данные успешно добавлены в базу данных!";
                        } else {
                            echo "Ошибка при добавлении данных в базу данных: " . $conn->error;
                        }
                    } else {
                        echo "Файл не удалось переместить!";
                    }

            }
        }
    break;
    //Удаляем оборудование
    case 'Delete':
        {
            $query1 = "SELECT * FROM equipment WHERE ID = $id";
            $result = $conn->query($query1);

            if ($result->num_rows > 0) 
            {
                $row = $result->fetch_assoc();
            }
            $targetDirectory = 'C:/ospanel/domains/Deeplom/equipment/';
            $oldFilePath = $targetDirectory . $row['name'] . '.pdf'; 
            if (file_exists($oldFilePath)) 
            {
                unlink($oldFilePath);
            }
            
            $query2 = "DELETE FROM equipment WHERE ID = $id";

            if ($conn->query($query2) === TRUE) 
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
