<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="База знаний.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="BttnLinks.css">
    <link rel="stylesheet" href="body.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>База знаний</title>
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
        <div class="DBK">
            <div class="Search">
                <input type="search" id="searchInput" name="searchInput" class="SearchInput" placeholder="Поиск...">
                <button type="submit" class="SearchBttn" onclick="searchFunc('FAQ')">
                        <img src="../icons/Search.svg" width="10px" alt="?">
                </button>
            </div>
            <div class="Links">
                <button class="Service" onclick="Service('Service',<?php echo $_SESSION['logged_in']?>)" >Обслуживание</button>
                <button class="Accedent" onclick="Accedent('Accedent',<?php echo $_SESSION['logged_in']?>)" >Инцидент</button>
                <button class="addBttm" onclick="addFAQ()">
                <img src="/icons/add.svg" width="10px" alt="+">
                </button>
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <div class="FAQHeader">
                            <h2 class="FAQTitle">Добавить новый FAQ</h2>
                            <span class="close" onclick="closeModal()">&times;</span>
                        </div>
                        <form id="faqForm">
                            <div class="ThemeAndContent">
                                <div class="ThemeDiv">
                                    <label for="theme">Тема:</label>
                                    <input type="text" id="theme" name="theme" required>
                                </div>
                                <div class="ContentDiv">
                                    <label for="content">Контент:</label>
                                    <textarea id="content" name="content" required></textarea>
                                </div>
                                <div class="Radios">
                                <input id="radio-1" type="radio" name="radio" value="Обслуживание" checked>
                                <label for="radio-1">Обслуживание</label>
                                <input id="radio-2" type="radio" name="radio" value="Инцидент" checked>
                                <label for="radio-2">Инцидент</label>
                                </div>
                            </div>
                        <button class="bttnAddNewFAQ" type="button" onclick="addNewFAQ('Create')">Создать</button>
                        </form>
                    </div>
                </div>
                <div id="myModal2" class="modal2">
                <div class="modal-content">
                    <div class="FAQHeader">
                        <h2 class="FAQTitle">Изменить FAQ</h2>
                        <span class="close" onclick="closeModal2()">&times;</span>
                    </div>
                    <form id="faqForm">
                        <div class="ThemeAndContent">
                            <div class="ThemeDiv">
                                <label for="theme1">Тема:</label>
                                <input type="text" id="theme1" name="theme" value="">
                            </div>
                            <div class="ContentDiv">
                                <label for="content1">Контент:</label>
                                <textarea id="content1" name="content"></textarea>
                            </div>
                            <div class="Radios">
                            
                                <input id="radio-11" type="radio" name="radio1" value="Обслуживание">
                                <label for="radio-11">Обслуживание</label>
                                <input id="radio-21" type="radio" name="radio1" value="Инцидент">
                                <label for="radio-21">Инцидент</label>
                            </div>
                        </div>
                        <button data-id="" class="bttnAddNewFAQ" type="button" onclick="ChangeFunc(this,'ChangeFunc')">Изменить</button>
                    </form>
                </div>
            </div>
            </div>
            <div class="Occasions" id="Occasions">
            <?php
                    $query = "SELECT * FROM knowledge WHERE type = ('Инцидент' OR 'Обслуживание')";
                    $result = $conn->query($query);


                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='Structure'>";
                        echo "<input class='ContentPlaque' type='hidden' value='{$row['ID']}'>";
                        echo "<button class='Info' data-id='{$row['ID']}' onclick=\"loadContent(this, 'Load')\">";
                        echo "<div class='themeHeader'>";
                        echo "{$row['theme']}";
                        echo "</div>";
                        echo "<div class='hidden-content' data-id='{$row['ID']}'></div>";
                        echo "</button>";
                        if($_SESSION['logged_in']==3)
                        {
                        echo "<div class='contentLinks'>";
                        echo    "<a class='changeContent' data-id='{$row['ID']}' onclick=\"changeContent(this,'Change')\">изменить</a>";
                        echo    "<a class='deleteContent' data-id='{$row['ID']}' onclick=\"deleteContent(this,'Delete')\">удалить</a>";
                        echo "</div>";
                        }
                        echo "</div>";
                    }
                } else 
                {}
                
                $conn->close();

            ?>
            </div>
        </div>
    </div>
    <script src="scripts.js">
    </script>
</body>
</html>