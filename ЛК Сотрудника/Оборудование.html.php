<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Оборудование.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="BttnLinks.css">
    <link rel="stylesheet" href="body.css">
    <title>Оборудование</title>
    <?php
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 3) {
        // если пользователь не вошел в систему, перенаправляем на страницу логина
        session_destroy();
        header("Location: ../Вход/Страница входа.html");
        exit();
    }
    $idd = $_COOKIE['ID'];

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
                    <a href="../Вход/Страница входа.html" class="LogOut">Выход</a>
                </div>
                <div class="SI2">
                    <img src="<?php echo $_SESSION['photo'];?>" alt="ava" class="Ava">
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
                <div class="linkone">
                    <img src="../icons/branchicons/шестеренка.svg" alt="icon">
                    <a class="HrefLink"href="Настройки.html.php">Настройки</a >
                </div>
            </div>
        </div>
        <div class="Equipment">
            <div class="EqHeader">
                <div class="EquipmentTitle">
                    <p>Все оборудование</p>
                    <p id="AllEquip">3</p>
                </div>
                <div class="Search">
                    <input type="search" class="SearchInput" placeholder="Поиск оборудования">
                    <button class="SearchBttn">
                        <img src="../icons/Search.svg" width="10px" alt="?">
                    </button>
                </div>
            </div>
           <ul class="EquipList">
            <li class="NEquip">
                <ul class="EquipInfo">
                    <li id="7354">#7354: <b>Осциллограф 5М2827</b></li>
                    <li id="SerialN">Серийный номер: 234545724154</li>
                    <li id="Otdel">Отдел: НПК-20</li>
                </ul>
                <button>Техническая документация</button>
            </li>
            <li class="NEquip">
                <ul class="EquipInfo">
                    <li id="8351">#8351: <b>Сетевой коммутатор IS-Net-1</b></li>
                    <li id="SerialN">Серийный номер: 863237086135</li>
                    <li id="Otdel">Отдел: НПК-9</li>
                </ul>
                <button>Техническая документация</button>
            </li>
            <li class="NEquip">
                <ul class="EquipInfo">
                    <li id="1239">#1239: <b>ПК IS-PC-mini</b></li>
                    <li id="SerialN">Серийный номер: 007821444321</li>
                    <li id="Otdel">Отдел: ОАСУ</li>
                </ul>
                <button>Техническая документация</button>
            </li>
           </ul>
        </div>
    </div>
    <script src="scripts.js">
    </script>
</body>
</html>