<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Клиенты.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="BttnLinks.css">
    <link rel="stylesheet" href="body.css">
    <script src="scripts.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Клиенты</title>
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
        <div class="Users">
        <?php
                $query = "SELECT * FROM user WHERE usertype = 1 ";
                $result = $conn->query($query);
                $count = mysqli_num_rows($result);
        ?>
            <div class="UserHeader">
                <div class="Polzovateli">
                    <p>Все пользователи</p>
                    <p id="All"><?php echo $count;?></p>
                </div>
                    <div class="Search">
                        <input type="search" id="searchInput" name="searchInput" class="SearchInput" placeholder="Поиск пользователей">
                        <button type="submit" class="SearchBttn" onclick="searchFunc('Clients')">
                            <img src="../icons/Search.svg" width="10px" alt="?">
                        </button>
                    </div>
            </div>
            <div id="userList">
                    <?php
                    if ($conn->connect_error) {
                        die("Ошибка подключения к базе данных: " . $conn->connect_error);
                    }
                    
                    $query = "SELECT * FROM user WHERE usertype = 1";
                    $result = $conn->query($query);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            echo "<li class='ContentPlaque'>";
                            echo "<ul class='UserInfo'>";
                            echo "<li><b>{$row['name']} {$row['lastname']}</b></li>";
                            echo "<li><a class='LongEmail' href='mailto:{$row['email']}'>{$row['email']}</a></li>";
                            echo "<li><a href='tel:{$row['phone']}'>{$row['phone']}</a></li>";
                            echo "</ul>";
                            echo "<form method='post' action='ЗаявкиОтс.php'>";
                            echo "<button name='ID' value='{$row['ID']}')>Заявки пользователя</button>";
                            echo "</form>";
                            echo "</li>";

                        }
                    } else {
                    
                    }
                    
                    $conn->close();
                    ?>
            </div>


        </div>
    </div>

</body>
</html>