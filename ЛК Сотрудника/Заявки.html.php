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
        <div class="Applications" >
            <div class="Vagner"id="requests">
                <?php 
                $servername = "127.0.0.1";
                $username = "root";
                $password = "";
                $dbname = "istok";
                
                $conn = new mysqli($servername, $username, $password, $dbname);
                $userId=$_COOKIE["ID"];

                $query = "SELECT * FROM request WHERE  Request_response = $userId AND (Request_status!='Завершено' OR Request_status IS NULL) ORDER BY CreationDate DESC";
                $result = $conn->query($query);
                foreach ($result->fetch_all(MYSQLI_ASSOC) as $заявление) {
                    
                    $query = "SELECT * FROM user WHERE ID= '$заявление[Request_owner]'";
                    $result1 = $conn->query($query);
                    $row1=$result1->fetch_array();

                    ?>
                <form class="form-get">
                    <input class="idd" type="hidden" value="<?php echo $заявление['ID']; ?>">
                    <button id="buton" type="submit" class="Zayavlenie">
                            <p id="Equip" style="color:#33c833;"><?php echo $заявление['Request_equip']; ?></p>
                            <p id="Theme"><?php echo $заявление['Request_theme']; ?></p>
                            <div class="ZayavBttn">
                                <p  id="number">№ <?php echo $заявление['ID']; ?></p>
                                <p id="ClientName"><?php echo $row1['name']; ?></p>
                                <p id="Status"><?php echo $заявление['Request_status']; ?></p>
                                <div class="Dates">
                                    <div class="DateCreation">
                                        <p id="Chislo"><?php echo date('d.m.Y H:i:s', strtotime($заявление['CreationDate'])); ?></p>
                                    </div>
                                    <div class="DateFinnish">
                                        <p id="Chislo"><?php echo $заявление['FinnishDate']; ?></p>
                                    </div>
                                </div>

                            </div>

                        
                    </button>
                </form>
                <?php } ?>
                <?php

                
                $query = "SELECT * FROM request WHERE  Request_response IS NULL  ORDER BY CreationDate DESC";
                $result = $conn->query($query);
                foreach ($result->fetch_all(MYSQLI_ASSOC) as $заявление) {
                    
                    $query = "SELECT * FROM user WHERE ID= '$заявление[Request_owner]'";
                    $result1 = $conn->query($query);
                    $row1=$result1->fetch_array();
                    


                    ?>
                <form class="form-get" >
                    <input class="idd" type="hidden"  value="<?php echo $заявление['ID']; ?>">    
                    <button id="buton" type="submit" class="Zayavlenie">
                            <p id="Equip"style="color:#ff6000;"><?php echo $заявление['Request_equip']; ?></p>
                            <p id="Theme"><?php echo $заявление['Request_theme']; ?></p>
                            <div class="ZayavBttn">
                                <p  id="number">№ <?php echo $заявление['ID']; ?></p>
                                <p id="ClientName"><?php echo $row1['name']; ?></p>
                                <p id="Status"><?php echo $заявление['Request_status']; ?></p>
                                <div class="Dates">
                                    <div class="DateCreation">
                                        <p id="Chislo"><?php echo date('d.m.Y H:i:s', strtotime($заявление['CreationDate'])); ?></p>
                                    </div>
                                    <div class="DateFinnish">
                                        <p id="Chislo"><?php echo $заявление['FinnishDate']; ?></p>
                                    </div>
                                </div>

                            </div>

                        
                    </button>
                </form>
                <?php } ?>
            </div>
            <div class="Messanger" id="vou">
              
               
            </div>
        </div>
    </div>
    <script src="scripts.js">
    </script>
</body>
</html>