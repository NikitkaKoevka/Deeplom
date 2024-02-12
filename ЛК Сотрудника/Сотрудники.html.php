<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Сотрудники.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="BttnLinks.css">
    <link rel="stylesheet" href="body.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Сотрудники</title>
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
        <div class="Sotrud">
        <?php
                $query = "SELECT * FROM user WHERE (usertype = 3 OR usertype = 2) ";
                $result = $conn->query($query);
                $count = mysqli_num_rows($result);
        ?>
            <div class="SotrudHeader">
                <div class="SotrudTitle">
                    <p>Все сотрудники</p>
                    <p id="All"><?php echo $count;?></p>
                </div>
                <div class="Search">
                        <input type="search" id="searchInput" name="searchInput" class="SearchInput" placeholder="Поиск сотрудников">
                        <button type="submit" class="SearchBttn" onclick="searchFunc('Employee')">
                            <img src="../icons/Search.svg" width="10px" alt="?">
                        </button>
                </div>
                <?php
                        if($_SESSION['logged_in']==3)
                echo '<button class="addBttm" onclick="addSotrud()"><img src="../icons/add.svg" width="5px" alt="?"></button>'
                ?>
            </div>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="AddSotrudHeader">
                        <h2 class="AddSotrudTitle">Добавить нового сотрудника</h2>
                        <span class="close" onclick="closeModal()">&times;</span>
                    </div>
                    <form id="SotrudForm">
                        <div class="SotrudDetails">
                            <div class="NameDiv">
                                <label for="name">Имя:</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="LastNameDiv">
                                <label for="lastname">Фамилия:</label>
                                <input type="text" id="lastname" name="lastname" required>
                            </div>
                            <div class="EmailDiv">
                                <label for="email">Почта:</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="PhoneDiv">
                                <label for="phone">Телефон:</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                            <div class="AccessLevelDiv">
                                <label for="accessLevel">Уровень доступа:</label>
                                <select id="accessLevel" name="accessLevel" required>
                                    <option value="2">Сотрудник</option>
                                    <option value="3">Админ</option>
                                </select>
                            </div>
                        </div>
                        <button class='bttnAddNewSotrud' type='button' onclick="addNewSotrud('Create')">Создать</button>

                    </form>
                </div>
            </div>
            <div id="myModal2" class="modal2">
            <div class="modal-content">
                    <div class="AddSotrudHeader">
                        <h2 class="AddSotrudTitle">Изменить сотрудника</h2>
                        <span class="close" onclick="closeModal2()">&times;</span>
                    </div>
                    <form id="SotrudForm">
                        <div class="SotrudDetails">
                            <div class="NameDiv">
                                <label for="name">Имя:</label>
                                <input type="text" id="name1" name="name" required>
                            </div>
                            <div class="LastNameDiv">
                                <label for="lastname">Фамилия:</label>
                                <input type="text" id="lastname1" name="lastname" required>
                            </div>
                            <div class="EmailDiv">
                                <label for="email">Почта:</label>
                                <input type="email" id="email1" name="email" required>
                            </div>
                            <div class="PhoneDiv">
                                <label for="phone">Телефон:</label>
                                <input type="tel" id="phone1" name="phone" required>
                            </div>
                            <div class="AccessLevelDiv">
                                <label for="accessLevel">Уровень доступа:</label>
                                <select id="accessLevel1" name="accessLevel" required>
                                    <option value="2">Сотрудник</option>
                                    <option value="3">Админ</option>
                                </select>
                            </div>
                        </div>
                        <button data-id="" class="bttnAddNewSotrud" type="button" onclick="ChangeFuncEmployee(this,'ChangeFunc')">Изменить</button>
                    </form>
                    </div>
                </div>
            <div id="userList">
                    <?php
                    if ($conn->connect_error) {
                        die("Ошибка подключения к базе данных: " . $conn->connect_error);
                    }
                    
                    $query = "SELECT * FROM user WHERE (usertype = 3 OR usertype = 2)";
                    $result = $conn->query($query);
                    
                    if (($result->num_rows > 0)) {
                        while ($row = $result->fetch_assoc()) {

                            echo "<li class='ContentPlaque'>";
                            echo "<ul class='UserInfo'>";
                            echo "<li>№{$row['ID']} <b>{$row['name']} {$row['lastname']}</b></li>";
                            echo "<li><a class='LongEmail' href='mailto:{$row['email']}'>{$row['email']}</a></li>";
                            echo "<li><a href='tel:{$row['phone']}'>{$row['phone']}</a></li>";
                            echo "</ul>";
                            echo "<div style = 'display:flex; flex-direction:row; align-items:center'>";
                            if($_SESSION['logged_in']==3)
                            {
                                echo "<button data-id='{$row['ID']}' class='EditBttm' onclick=\"changeEmployee(this,'Change')\"><img src='../icons/Change.svg' width='5px' alt='?'></button>";
                                echo "<button data-id='{$row['ID']}' class='Deletebttm' onclick=\"deleteEmployee(this,'Delete')\"><img src='../icons/Delete.svg' width='10px' alt='?'></button>";
                            } 
                            echo "</div>";
                            echo "</li>";
                        }
                    } else {}
                    
                    
                    $conn->close();
                    ?>
            </div>
        </div>

    </div>
    <script src="scripts.js">
    </script>
</body>
</html>