<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

$searchInput = $_POST["searchInput"];
$emploeeType = $_SESSION['logged_in'];
$searchType = $_POST["searchType"];

switch($searchType)
{
    case 'Clients':
        {
            $query = "SELECT * FROM user WHERE usertype = 1";

            if (!empty($searchInput)) {
                // Добавьте условие для фильтрации результатов
                $query .= " AND (";
                $query .= "ID LIKE '%$searchInput%' OR ";
                $query .= "name LIKE '%$searchInput%' OR ";
                $query .= "lastname LIKE '%$searchInput%' OR ";
                $query .= "(name LIKE '%$searchInput%' AND lastname LIKE '%$searchInput%')";
                $query .= ")";
            }
            
            $result = $conn->query($query);
            
            if ($result->num_rows > 0) 
            {
                $count = $result->num_rows;
            
            
                while ($row = $result->fetch_assoc()) {
                    $html .= "<li class='ContentPlaque'>";
                    $html .= "<ul class='UserInfo'>";
                    $html .= "<li><b>{$row['name']} {$row['lastname']}</b></li>";
                    $html .= "<li><a href='mailto:{$row['email']}'>{$row['email']}</a></li>";
                    $html .= "<li><a href='tel:{$row['phone']}'>{$row['phone']}</a></li>";
                    $html .= "</ul>";
                    $html .= "<form method='post' action='ЗаявкиОтс.php'>";
                    $html .= "<button name='ID' value='{$row['ID']}'>Заявки пользователя</button>";
                    $html .= "</form>";
                    $html .= "</li>";
                }
            
                echo $html;
            } else {
                echo "Нет данных о пользователях.";
            }
            
        };
    break;
    case 'Employee':
            {
            $query = "SELECT * FROM user WHERE (usertype = 2 or usertype = 3)";

            if (!empty($searchInput)) {
                // Добавьте условие для фильтрации результатов
                $query .= " AND (";
                $query .= "ID LIKE '%$searchInput%' OR ";
                $query .= "name LIKE '%$searchInput%' OR ";
                $query .= "lastname LIKE '%$searchInput%' OR ";
                $query .= "(name LIKE '%$searchInput%' AND lastname LIKE '%$searchInput%')";
                $query .= ")";
            }
            
            $result = $conn->query($query);
            
            if ($result->num_rows > 0) 
            {
                $count = $result->num_rows;
            
            
                while ($row = $result->fetch_assoc()) {
                    $html .= "<li class='ContentPlaque'>";
                    $html .= "<ul class='UserInfo'>";
                    $html .= "<li>#{$row['ID']}: <b>{$row['name']} {$row['lastname']}</b></li>";
                    $html .= "<li>Почта: <a href='mailto:{$row['email']}'>{$row['email']}</a></li>";
                    $html .= "<li>Телефон: <a href='tel:{$row['phone']}'>{$row['phone']}</a></li>";
                    $html .= "</ul>";
                    if($emploeeType==3)
                    {
                        $html .= "<div style = 'display:flex; flex-direction:row'>";
                        $html .= "<button  data-id='{$row['ID']}' class='EditBttm' onclick=\"changeEmployee(this,'Change')\"><img src='../icons/Change.svg' width='5px' alt='?'></button>";
                        $html .= "<button  data-id='{$row['ID']}' class='Deletebttm' onclick=\"deleteEmployee(this,'Delete')\"><img src='../icons/Delete.svg' width='10px' alt='?'></button>";
                        $html .= "</div>";
                    }
                    $html .= "</li>";
                }
            
                echo $html;
            } else {
                echo "Нет данных о пользователях.";
            }
            
        };
    break;
    case 'FAQ':
        {
        $query = "SELECT * FROM knowledge WHERE type = ('Инцидент' OR 'Обслуживание')";

        if (!empty($searchInput)) {
            // Добавьте условие для фильтрации результатов
            $query .= " AND (";
            $query .= "theme LIKE '%$searchInput%' OR ";
            $query .= "content LIKE '%$searchInput%'";
            $query .= ")";
        }
        
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) 
        {
            $count = $result->num_rows;
        
        
            while ($row = $result->fetch_assoc()) {
                $html .= "<div class='Structure'>";
                $html .= "<input class='ContentPlaque' type='hidden' value='{$row['ID']}'>";
                $html .= "<button class='Info' data-id='{$row['ID']}' onclick=\"loadContent(this, 'Load')\">";
                $html .= "<div class='themeHeader'>";
                $html .= "{$row['theme']}";
                $html .= "</div>";
                $html .= "<div class='hidden-content' data-id='{$row['ID']}'></div>";
                $html .= "</button>";
                if($emploeeType==3)
                    {
                        $html .= "<div class='contentLinks'>";
                        $html .= "<a class='changeContent' data-id='{$row['ID']}' onclick=\"changeContent(this,'Change')\">изменить</a>";
                        $html .= "<a class='deleteContent' data-id='{$row['ID']}' onclick=\"deleteContent(this,'Delete')\">удалить</a>";
                        $html .= "</div>";
                    }
                $html .= "</div>";
                }
        
            echo $html;
        } else {
            echo "Нет данных.";
        }
        
    };
    break;
    case 'Equip':
        {
        $query = "SELECT * FROM equipment ";

        if (!empty($searchInput)) {
            // Добавьте условие для фильтрации результатов
            $query .= "WHERE name LIKE '%$searchInput%' OR ";
            $query .= "serial LIKE '%$searchInput%' OR ";
            $query .= "depart LIKE '%$searchInput%' ";

        }
        
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) 
        {
            $count = $result->num_rows;
        
        
            while ($row = $result->fetch_assoc()) {
                $html .= "<li class='ContentPlaque'>";
                $html .= "<ul class='EquipInfo'>";
                $html .=        "<li id='{$row['ID']}'><b>{$row['name']}</b></li>";
                //$html .=        "<li name='SerialN'>Серийный номер: {$row['serial']}</li>";
                //$html .=        "<li name='Otdel'>Отдел: {$row['depart']}</li>";
                $html .= "</ul>";
                $html .=        "<div style = 'display:flex; flex-direction:row; align-items:center'>
                                        <button id='Documentbttm' value='{$row['doc']}' onclick=\"OpenTechFile('{$row['doc']}')\"><img src='../icons/Document.svg' width='5px' alt='?'></button>";
                                        if($_SESSION['logged_in']==3){
                $html .=        "
                                        <div style = 'display:flex; flex-direction:row'>
                                            <button data-id='{$row['ID']}' class='EditBttm' onclick=\"changeEquip(this,'Change')\"><img src='../icons/Change.svg' width='10px' alt='?'></button>
                                            <button data-id='{$row['ID']}' class='Deletebttm' onclick=\"deleteEquip(this,'Delete')\"><img src='../icons/Delete.svg' width='10px' alt='?'></button>
                                        </div>
                                </div>";
                                        }
                $html .=    "</li>";
            }
        
            echo $html;
        } else {
            echo "Нет данных.";
        }
        
    };
    break;
}

$conn->close();
?>
