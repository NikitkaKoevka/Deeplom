<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}
$Theme = $_POST["Theme"];
$Content = $_POST['Content'];
$Type = $_POST['Type'];
$Option= $_POST['Option'];
$id=$_POST['id'];
$ustype=$_POST['UserType'];
switch($Option)
{
    //СОздаем новую FAQ
    
    case 'Create':
        {
            $query = "INSERT INTO knowledge (ID, theme, content, type) 
            VALUES (NULL, '$Theme', '$Content', '$Type')";
            if ($conn->query($query) === TRUE) 
            {
                echo '<script>window.location = "База знаний.html.php";</script>';
                exit();
            } else 
            {
                echo '<script>alert("Ошибка при создании FAQ: ' .  $conn->error . '");</script>';;
                exit();
            }
        }
    break;
    //Загружаем все FAQ
    case 'Load':
        {
            // Получаем ID вопроса из запроса
            $themeID = isset($_POST['id']) ? $_POST['id'] : null;

            if ($themeID !== null) {
                // Экранируйте полученное значение, чтобы избежать SQL-инъекций
                $themeID = $conn->real_escape_string($themeID);

                // Выполняем SQL-запрос для получения информации о вопросе
                $sql = "SELECT content FROM knowledge WHERE ID = '$themeID'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $content = $row['content'];

                    // Возвращаем данные в формате HTML
                    $html .= "$content";
                    echo $html;
                } else {

                    $html .= "Вопрос не найден.";
                    echo $html;
                }
            } else {

                $html .= "Неверные параметры запроса.";
                echo $html;
            }
        }
    break;
    //Показываем окно для изменения FAQ
    case 'Change':
        {
            $query = "SELECT * FROM knowledge WHERE ID = $id";
            $result = $conn->query($query);
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        
                // Создаем ассоциативный массив с данными
                $data = array(
                    'theme' => $row['theme'],
                    'content' => $row['content'],
                    'type' => $row['type']
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
            $query = "UPDATE knowledge SET theme = '$Theme', content = '$Content', type = '$Type' WHERE ID = $id";

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
            $query = "DELETE FROM knowledge WHERE ID = $id";
            
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
    //Сорировака FAQ по Обслуживанию
    case 'Service':
        {
            $query = "SELECT * FROM knowledge WHERE type = 'Обслуживание'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Формируем HTML код с использованием конкатенации
                $html .= "<div class='Structure'>";
                $html .= "<input class='ContentPlaque' type='hidden' value='{$row['ID']}'>";
                $html .= "<button class='Info' data-id='{$row['ID']}' onclick=\"loadContent(this, 'Load')\">";
                $html .= "<div class='themeHeader'>";
                $html .= "{$row['theme']}";
                $html .= "</div>";
                $html .= "<div class='hidden-content' data-id='{$row['ID']}'></div>";
                $html .= "</button>";
                if($ustype==3)
                    {
                        $html .= "<div class='contentLinks'>";
                        $html .= "<a class='changeContent' data-id='{$row['ID']}' onclick=\"changeContent(this,'Change')\">изменить</a>";
                        $html .= "<a class='deleteContent' data-id='{$row['ID']}' onclick=\"deleteContent(this,'Delete')\">удалить</a>";
                        $html .= "</div>";
                    }
                $html .= "</div>";
                }
                echo $html;
                }
            else {
                echo "Нет данных";
            }

            $conn->close();
        }
    break;
    //Сорировака FAQ по Инциденту
    case 'Accedent':
        {
            $query = "SELECT * FROM knowledge WHERE type = 'Инцидент'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Формируем HTML код с использованием конкатенации
                $html .= "<div class='Structure'>";
                $html .= "<input class='ContentPlaque' type='hidden' value='{$row['ID']}'>";
                $html .= "<button class='Info' data-id='{$row['ID']}' onclick=\"loadContent(this, 'Load')\">";
                $html .= "<div class='themeHeader'>";
                $html .= "{$row['theme']}";
                $html .= "</div>";
                $html .= "<div class='hidden-content' data-id='{$row['ID']}'></div>";
                $html .= "</button>";
                if($ustype==3)
                    {
                        $html .= "<div class='contentLinks'>";
                        $html .= "<a class='changeContent' data-id='{$row['ID']}' onclick=\"changeContent(this,'Change')\">изменить</a>";
                        $html .= "<a class='deleteContent' data-id='{$row['ID']}' onclick=\"deleteContent(this,'Delete')\">удалить</a>";
                        $html .= "</div>";
                    }
                $html .= "</div>";
                }
                echo $html;
                }
            else {
                echo "Нет данных";
            }

            $conn->close();
        }
    break;
}



?>
