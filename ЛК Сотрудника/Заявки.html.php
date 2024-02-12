<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Заявки.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="BttnLinks.css">
    <link rel="stylesheet" href="body.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="request.js"></script>
    <title>Заявки</title>
    <?php
    session_start();
    if (!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] !== 3 && $_SESSION['logged_in'] !== 2)) {
        // если пользователь не вошел в систему, перенаправляем на страницу логина
        session_destroy();
        header("Location: ../Вход/Страница входа.html");
        exit();
    }    
    $idd = $_SESSION['UserID'];

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "istok";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $query = "SELECT * FROM user WHERE  ID = $idd ";
    $result = $conn->query($query);
    $roww=$result->fetch_array();
    $fname=$roww['name'];
    $lname=$roww['lastname'];
    $photo= $roww['photolink'];

    ?>
</head>
<body>
    <header>
        <div class="HeaderComplete">
            <div class="logo">
                <a href="Заявки.html.php">
                <img src="../icons/ISTOK.svg" class="ISTOK" alt="ISTOK">
                </a>
            </div>
            <div class="SotrudInfo">
                <div class="SI1">
                    <p class="FLName">
                    <?php echo $fname; ?><?php echo ' '; ?><?php echo $lname; ?>
                    </p >
                    <a href="../Вход/LogOut.php" class="LogOut">Выход</a>
                </div>
                <div class="SI2">
                    <img src="<?php echo $photo;?>" alt="ava" class="Ava">
                </div>
            </div>
        </div>
        
    </header>
    <div class="container">
        <div class="linkbars">
            <div class="mainlinks">
                <div class="linkone">
                    <img src="../icons/branchicons/заявка.svg" alt="icon">
                    <a class="HrefLink"href="Заявки.html.php">Заявки</a >
                </div>
                <div class="linkone">
                    <img src="../icons/branchicons/клиент.svg" alt="icon">
                    <a class="HrefLink"href="Клиенты.html.php">Клиенты</a >
                </div>
                
                <div class="linkone">
                    <img src="../icons/branchicons/оборудование.svg" alt="icon">
                    <a class="HrefLink"href="Оборудование.html.php">Оборудование</a >
                </div>
                <div class="linkone">
                    <img src="../icons/branchicons/сотрудник.svg" alt="icon">
                    <a class="HrefLink"href="Сотрудники.html.php">Сотрудники</a >
                </div>
                <div class="linkone">
                    <img src="../icons/branchicons/дешборд.svg" alt="icon">
                    <a class="HrefLink"href="Дэшборд.html.php">Дэшборд</a >
                </div>
                <div class="linkone">
                    <img src="../icons/branchicons/база знаниц.svg" alt="icon">
                    <a class="HrefLink"href="База знаний.html.php">База знаний</a >
                </div>
            </div>
            <div class="bottomlinks">
                <div class="linkone">
                    <img src="../icons/branchicons/поддержка.svg" alt="icon">
                    <p class="HrefLink" onclick="SupportAlert()">Поддержка</p >
                </div>
                <!--
                <div class="linkone">
                    <img src="../icons/branchicons/шестеренка.svg" alt="icon">
                    <a class="HrefLink"href="Настройки.html.php">Настройки</a >
                </div>
                -->
            </div>
        </div>
        <div class="Applications" >
            <div id='contextMenu'>
                <button id='deleteMessage' class='delete' onclick="deleteMessage()">
                    <img src='../icons/Delete.svg' width='10px' alt='?'>
                </button>
            </div>
            <div class="Vagner"id="requests">
                <?php 
                $servername = "127.0.0.1";
                $username = "root";
                $password = "";
                $dbname = "istok";
                
                $conn = new mysqli($servername, $username, $password, $dbname);
                
             
                $query = "SELECT * FROM request WHERE  Request_response = $idd AND (Request_status!='Завершено' OR Request_status IS NULL) ORDER BY CreationDate DESC";
                $result = $conn->query($query);
                foreach ($result->fetch_all(MYSQLI_ASSOC) as $заявление) {
                    
                    $query = "SELECT * FROM user WHERE ID= '$заявление[Request_owner]'";
                    $result1 = $conn->query($query);
                    $row1=$result1->fetch_array();



                    echo "<button id=\"buton\" class=\"Zayavlenie\" onclick=\"OpenReq('{$заявление['ID']}')\">";
                    echo "<input class=\"idd\" type=\"hidden\" value=\"{$заявление['ID']}\">";                  
                    echo "<p id=\"Equip\" style=\"color:#33c833;\">{$заявление['Request_equip']}</p>";
                    echo "<p id=\"Theme\">{$заявление['Request_theme']}</p>";
                    echo "<div class=\"ZayavBttn\">";
                    echo "<p id=\"number\">№ {$заявление['ID']}</p>";
                    echo "<p id=\"ClientName\">{$row1['name']}</p>";
                    echo "<p id=\"Status\">{$заявление['Request_status']}</p>";
                    echo "<div class=\"Dates\">";
                    echo "<div class=\"DateCreation\">";
                    echo "<p id=\"Chislo\">".$заявление['CreationDate']."</p>";
                    echo "</div>";
                    echo "<div class=\"DateFinnish\">";
                    echo "<p id=\"Chislo\">".$заявление['FinnishDate']."</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</button>";

                    } 

                    
                $query = "SELECT * FROM request WHERE  Request_response IS NULL  ORDER BY CreationDate DESC";
                $result = $conn->query($query);
                foreach ($result->fetch_all(MYSQLI_ASSOC) as $заявление) {
                    
                    $query = "SELECT * FROM user WHERE ID= '$заявление[Request_owner]'";
                    $result1 = $conn->query($query);
                    $row1=$result1->fetch_array();



                    echo "<button id=\"buton\" class=\"Zayavlenie\" onclick=\"OpenReq('{$заявление['ID']}')\">";
                    echo "<input class=\"idd\" type=\"hidden\" value=\"{$заявление['ID']}\">";                  
                    echo "<p id=\"Equip\" style=\"color:#ff6000;\">{$заявление['Request_equip']}</p>";
                    echo "<p id=\"Theme\">{$заявление['Request_theme']}</p>";
                    echo "<div class=\"ZayavBttn\">";
                    echo "<p id=\"number\">№ {$заявление['ID']}</p>";
                    echo "<p id=\"ClientName\">{$row1['name']}</p>";
                    echo "<p id=\"Status\">{$заявление['Request_status']}</p>";
                    echo "<div class=\"Dates\">";
                    echo "<div class=\"DateCreation\">";
                    echo "<p id=\"Chislo\">".date('d.m.Y H:i:s', strtotime($заявление['CreationDate']))."</p>";
                    echo "</div>";
                    echo "<div class=\"DateFinnish\">";
                    echo "<p id=\"Chislo\">{$заявление['FinnishDate']}</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</button>";

                    } 
                
                
                    ?>
            </div>
            <div class="Messanger" id="vou">

            </div>
        </div>
    </div>
    <script src="scripts.js">
    </script>
</body>
</html>