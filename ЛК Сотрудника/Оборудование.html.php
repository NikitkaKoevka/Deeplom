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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Оборудование</title>
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
        <div class="Equipment">
        <?php
                $query = "SELECT * FROM equipment ";
                $result = $conn->query($query);
                $count = mysqli_num_rows($result);
        ?>
            <div class="EqHeader">
                <div class="EquipmentTitle">
                    <p>Все оборудование</p>
                    <p id="All"><?php echo $count;?></p>
                </div>
                <div class="Search">
                    <input type="search" id="searchInput" name="searchInput" class="SearchInput" placeholder="Поиск оборудования">
                    <button class="SearchBttn" onclick="searchFunc('Equip')">
                        <img src="../icons/Search.svg" width="10px" alt="?">
                    </button>
                </div>
                <?php
                        if($_SESSION['logged_in']==3)
                echo '<button class="addBttm" onclick="addEquip()"><img src="../icons/add.svg" width="5px" alt="?"></button>'
                ?>
            </div>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="AddEquipHeader">
                        <h2 class="AddEquipTitle">Добавить новое оборудование</h2>
                        <span class="close" onclick="closeModal()">&times;</span>
                    </div>
                    <form id="EquipForm" >
                        <div class="EquipDetails">
                            <div class="NameDiv">
                                <label for="name">Название</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <!--<div class="SerialDiv">
                                <label for="serial">Серийный номер:</label>
                                <input type="text" id="serial" name="serial" required>
                            </div>
                            <div class="DepartDiv">
                                <label for="depart">Отдел:</label>
                                <input type="text" id="depart" name="depart" required>
                            </div>-->
                            <div class="DovDiv">
                                <label for="doc">Файл:</label>
                                <input accept="application/pdf" type="file" id="doc" name="doc" required>
                            </div>
                        </div>
                        <button class='bttnAddNewEquip' type='button' onclick="addNewEquip('Create')">Создать</button>
                        <!--<input class='bttnAddNewEquip' type="submit" id="Create" >-->
                    </form>
                    <div id="result"></div>
                </div>
            </div>
            <div id="myModal2" class="modal2">
            <div class="modal-content">
                    <div class="AddEquipHeader">
                        <h2 class="AddEquipTitle">Изменить оборудование</h2>
                        <span class="close" onclick="closeModal2()">&times;</span>
                    </div>
                    <form id="EquipForm">
                        <div class="EquipDetails">
                            <div class="NameDiv">
                                <label for="name1">Название</label>
                                <input type="text" id="name1" name="name" required>
                            </div>
                            <!--<div class="SerialDiv">
                                <label for="serial1">Серийный номер:</label>
                                <input type="text" id="serial1" name="lastname" required>
                            </div>
                            <div class="DepartDiv">
                                <label for="depart1">Отдел:</label>
                                <input type="text" id="depart1" name="depart" required>
                            </div>-->
                            <div class="DovDiv">
                                <label for="doc1">Файл:</label>
                                <input accept="application/pdf" type="file" id="doc1" name="doc" required>
                            </div>
                        </div>
                        <button data-id="" class="bttnAddNewEquip" type="button" onclick="ChangeFuncEquip(this,'ChangeFunc')">Изменить</button>
                    </form>
                    </div>
                </div>
           <ul id="EquipList">
           <?php
                    if ($conn->connect_error) {
                        die("Ошибка подключения к базе данных: " . $conn->connect_error);
                    }
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            echo    "<li class='ContentPlaque'>";
                            echo    "<ul class='EquipInfo'>";
                            echo        "<li id='{$row['ID']}'><b>{$row['name']}</b></li>";
                            //echo        "<li name='SerialN'><img src='../icons/Key.svg' width='10px' alt='?'> {$row['serial']}</li>";
                            //echo        "<li name='Otdel'><img src='../icons/Depart.svg' width='10px' alt='?'> {$row['depart']}</li>";
                            echo    "</ul>";
                            echo        "<div style = 'display:flex; flex-direction:row; align-items:center'>
                                        <button id='Documentbttm' value='{$row['doc']}' onclick=\"OpenTechFile('{$row['doc']}')\"><img src='../icons/Document.svg' width='5px' alt='?'></button>";
                                        if($_SESSION['logged_in']==3){
                            echo        "
                                            <div style = 'display:flex; flex-direction:row'>
                                            <button data-id='{$row['ID']}' class='EditBttm' onclick=\"changeEquip(this,'Change')\"><img src='../icons/Change.svg' width='5px' alt='?'></button>
                                            <button data-id='{$row['ID']}' class='Deletebttm' onclick=\"deleteEquip(this,'Delete')\"><img src='../icons/Delete.svg' width='10px' alt='?'></button>
                                            </div>
                                        </div>";
                                        }
                            echo    "</li>";

                        }
                    }
           ?>
        </div>
    </div>
    <script src="scripts.js">
    </script>
</body>
</html>