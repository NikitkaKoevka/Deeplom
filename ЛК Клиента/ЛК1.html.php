<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="ЛК1.css">
    <link rel="icon" href="ISTOK.ico">
    <title>Личный кабинет</title>
    <?php
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 1) {
        // если пользователь не вошел в систему, перенаправляем на страницу логина
        session_destroy();
        header("Location: ../Вход/Страница входа.html");
        exit();
    }
    $idd = $_COOKIE['ID'];
    ?>
</head>
<body>
    <div class="container">
        <div class="messenger">
            <?php 
            $servername = "127.0.0.1";
            $username = "root";
            $password = "";
            $dbname = "istok";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            $userId = $_COOKIE["ID"];
            $query = "SELECT * FROM request WHERE Request_owner = $userId ORDER BY CreationDate DESC";
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                $data = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($data as $заявление) {
                    ?>
                    <form action="ЛК1переписка.html.php" method="post">
                        <input type="hidden" name="conversation_id" value="<?php echo $заявление['ID']; ?>">
                        <button class="Zayavlenie" type="submit">
                            <p id="Equip"><?php echo $заявление['Request_equip']; ?></p>
                            <p id="Theme"><?php echo $заявление['Request_theme']; ?></p>
                            <div class="ZayavBttn">
                                <p id="number">№ <?php echo $заявление['ID']; ?></p>
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
                    <?php
                }
            }
            $conn->close();
            ?>
        </div>
        <div class="profile">
            <div>
                <div class="avajp">
                    <img src="<?php echo $_SESSION['photo'];?>" alt="<?php echo $_SESSION['photo'];?>" class="avatarka">
                </div>
                <div class="info">
                    <p id="Fname" style="font-weight:600"><?php echo $_SESSION['first_name']; ?></p>
                    <p id="Sname" style="font-weight:600"><?php echo $_SESSION['last_name']; ?></p>
                </div>
            </div>
            <div class="bttns">
                <button onclick="window.location.href='ЛКПодатьЗаявку.html.php'"style="width: 163px">создать заявление</button>
                <button onclick="window.location.href='../Вход/LogOut.php'" class="LogOut">Выйти</button>
            </div>
        </div>
    </div>
</body>
</html>
