<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="ЛК1.css">
    <link rel="icon" href="ISTOK.ico">
    <title>Личный кабинет</title>
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
    $userID=$_SESSION['UserID'];
    $sql = "SELECT * FROM user WHERE ID = '$userID'";
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    $firstName= $row['name'];
    $lastName= $row['lastname'];
    $email= $row['email'];
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 1) {
        // если пользователь не вошел в систему, перенаправляем на страницу логина
        session_destroy();
        header("Location: ../Вход/Страница входа.html");
        exit();
    }
    
    ?>
</head>
<body>
    <div class="container">
        <div id="myModal" class="modal">
                    <div class="modal-content">
                            <span class="close" onclick="closeModal()">
                                <img class="sendback" src="../icons/SendBack.svg" alt="<">
                            </span>
                        <div id="messages"></div>
                        <form id="chat-form" enctype='multipart/form-data'>
                                <div class="sendmess">
                                    <textarea id="chat-message" cols="30" rows="10" class="typetext" placeholder="Напишите сообщение"></textarea>
                                    <label for="paperclip">
                                        <img src="../icons/скрепка.svg" alt="p" class="paperclip">
                                    </label>
                                    <input accept='image/jpeg, image/png' id="paperclip" type="file" >
                                    <button class="send"><img src='../icons/Send.svg' alt='p' class='sendpic' ></button>
                                </div>
                        </form>
                    </div>
        </div>
        <div id="myModal2" class="modal">
                    <div class="modal-content">
                            <span class="close" onclick="closeModal2()">
                                <img class="sendback" src="../icons/SendBack.svg" alt="<">
                            </span>
                        <div id="add-form">
                            <input type="text" id="theme" name="theme" placeholder="Тема" required>
                            <input type="text" id="equip" name="equip" placeholder="Оборудование" required>
                            <textarea id="content" name="content" placeholder="Описание" required></textarea>
                            <button id="send" class="send" onclick="submitForm()">Отправить</button>
                        </div>
                    </div>
        </div>
        <div id="myModal3" class="modal">
                    <div class="modal-content wid">
                            <span class="close" onclick="closeModal3()">
                                <img class="sendback" src="../icons/SendBack.svg" alt="<">
                            </span>
                        <div id="set-form">
                            <input type="text" id="name" name="name" placeholder="Имя" value="<?php echo $firstName; ?>">
                            <input type="text" id="lastname" name="lastname" placeholder="Фамилия" value="<?php echo $lastName; ?>">
                            <input type="text" id="email" name="email" placeholder="Почта" value="<?php echo $email; ?>">
                            <input type="text" id="password" name="password" placeholder="Пароль">
                            <input type="text" id="password2" name="password2" placeholder="Повторите пароль">
                            <button id="set" class="set" onclick="setForm()">Сохранить</button>
                        </div>
                    </div>
        </div>
        <div class="containProfStack">
            <div class="divStack">
                <img width="30px" src="../icons/stack.svg" alt="?">
            </div>
            <div class="profile">
                    <div>
                        <div class="info">
                            <p id="Fname" style="font-weight:600"><?php echo $firstName; ?></p>
                            <p id="Sname" style="font-weight:600"><?php echo $lastName; ?></p>
                        </div>
                    </div>
                    <div class="bttns">
                        <button onclick="openCreatePlaque()" >
                            <img class="sidebarImg" src="../icons/create_appl.svg" alt="!">
                            <p class="labelBttns">Создать</p>
                        </button>
                        <button onclick="openSettingsPlaque()">
                            <img class="sidebarImg" src="../icons/settings.svg" alt="!">
                            <p class="labelBttns">Настроить</p>
                        </button>
                        <button onclick="window.location.href='../Вход/LogOut.php'" class="LogOut">
                            <img class="sidebarImg" src="../icons/logout.svg" alt="!">
                            <p class="labelBttns">Выйти</p>
                        </button>
                    </div>
                </div>
        </div>
        <div class="messenger">
            <?php 
            $servername = "127.0.0.1";
            $username = "root";
            $password = "";
            $dbname = "istok";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            $userId = $_SESSION['UserID'];
            $query = "SELECT * FROM request WHERE Request_owner = $userId ORDER BY CreationDate DESC";
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                $data = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($data as $заявление) {
                    ?>
                    <div class="reqPath">

                    <button class="Zayavlenie" type="submit" onclick="openReq(<?php echo $заявление['ID']?>)">
                        <input type="hidden" id="conID" value="<?php echo $заявление['ID']; ?>">
                        <p id="number">№ <?php echo $заявление['ID']; ?></p>
                        <p id="Theme"><?php echo $заявление['Request_theme']; ?></p>
                        <div class="ZayavBttn">
                            <p id="Status"><?php echo $заявление['Request_status']; ?></p>
                            <div class="Dates">
                                <div class="DateCreation">
                                    <p id="Chislo"><?php echo $заявление['CreationDate']; ?></p>
                                </div>
                                <div class="DateFinnish">
                                    <p id="Chislo"><?php echo $заявление['FinnishDate']; ?></p>
                                </div>
                            </div>
                        </div>
                    </button>
                    <?php 
                    if($заявление['Request_status']=='Завершено'&& $заявление['mark']!=(1||2||3||4||5))
                    {
                    ?>
                    <form id="ratingForm">
                        <input type="hidden" name="conversation_id" value="<?php echo $заявление['ID']; ?>">
                        <div id="ratingStars">
                            <input type="radio" name="rating" value="1" id="star_<?php echo $заявление['ID']; ?>_1">
                                <label for="star_<?php echo $заявление['ID']; ?>_1">
                                    <svg style="cursor: pointer" width="30px" height="30px" viewBox="0 0 24 24">
                                        <path class="starIcon" d="M9.15316 5.40838C10.4198 3.13613 11.0531 2 12 2C12.9469 2 13.5802 3.13612 14.8468 5.40837L15.1745 5.99623C15.5345 6.64193 15.7144 6.96479 15.9951 7.17781C16.2757 7.39083 16.6251 7.4699 17.3241 7.62805L17.9605 7.77203C20.4201 8.32856 21.65 8.60682 21.9426 9.54773C22.2352 10.4886 21.3968 11.4691 19.7199 13.4299L19.2861 13.9372C18.8096 14.4944 18.5713 14.773 18.4641 15.1177C18.357 15.4624 18.393 15.8341 18.465 16.5776L18.5306 17.2544C18.7841 19.8706 18.9109 21.1787 18.1449 21.7602C17.3788 22.3417 16.2273 21.8115 13.9243 20.7512L13.3285 20.4768C12.6741 20.1755 12.3469 20.0248 12 20.0248C11.6531 20.0248 11.3259 20.1755 10.6715 20.4768L10.0757 20.7512C7.77268 21.8115 6.62118 22.3417 5.85515 21.7602C5.08912 21.1787 5.21588 19.8706 5.4694 17.2544L5.53498 16.5776C5.60703 15.8341 5.64305 15.4624 5.53586 15.1177C5.42868 14.773 5.19043 14.4944 4.71392 13.9372L4.2801 13.4299C2.60325 11.4691 1.76482 10.4886 2.05742 9.54773C2.35002 8.60682 3.57986 8.32856 6.03954 7.77203L6.67589 7.62805C7.37485 7.4699 7.72433 7.39083 8.00494 7.17781C8.28555 6.96479 8.46553 6.64194 8.82547 5.99623L9.15316 5.40838Z"/>
                                    </svg>
                                </label>
                            <input type="radio" name="rating" value="2" id="star_<?php echo $заявление['ID']; ?>_2">
                                <label for="star_<?php echo $заявление['ID']; ?>_2">
                                    <svg style="cursor: pointer" width="30px" height="30px" viewBox="0 0 24 24">
                                        <path class="starIcon" d="M9.15316 5.40838C10.4198 3.13613 11.0531 2 12 2C12.9469 2 13.5802 3.13612 14.8468 5.40837L15.1745 5.99623C15.5345 6.64193 15.7144 6.96479 15.9951 7.17781C16.2757 7.39083 16.6251 7.4699 17.3241 7.62805L17.9605 7.77203C20.4201 8.32856 21.65 8.60682 21.9426 9.54773C22.2352 10.4886 21.3968 11.4691 19.7199 13.4299L19.2861 13.9372C18.8096 14.4944 18.5713 14.773 18.4641 15.1177C18.357 15.4624 18.393 15.8341 18.465 16.5776L18.5306 17.2544C18.7841 19.8706 18.9109 21.1787 18.1449 21.7602C17.3788 22.3417 16.2273 21.8115 13.9243 20.7512L13.3285 20.4768C12.6741 20.1755 12.3469 20.0248 12 20.0248C11.6531 20.0248 11.3259 20.1755 10.6715 20.4768L10.0757 20.7512C7.77268 21.8115 6.62118 22.3417 5.85515 21.7602C5.08912 21.1787 5.21588 19.8706 5.4694 17.2544L5.53498 16.5776C5.60703 15.8341 5.64305 15.4624 5.53586 15.1177C5.42868 14.773 5.19043 14.4944 4.71392 13.9372L4.2801 13.4299C2.60325 11.4691 1.76482 10.4886 2.05742 9.54773C2.35002 8.60682 3.57986 8.32856 6.03954 7.77203L6.67589 7.62805C7.37485 7.4699 7.72433 7.39083 8.00494 7.17781C8.28555 6.96479 8.46553 6.64194 8.82547 5.99623L9.15316 5.40838Z"/>
                                    </svg>
                                </label>
                            <input type="radio" name="rating" value="3" id="star_<?php echo $заявление['ID']; ?>_3">
                                <label for="star_<?php echo $заявление['ID']; ?>_3">
                                    <svg style="cursor: pointer" width="30px" height="30px" viewBox="0 0 24 24">
                                        <path class="starIcon" d="M9.15316 5.40838C10.4198 3.13613 11.0531 2 12 2C12.9469 2 13.5802 3.13612 14.8468 5.40837L15.1745 5.99623C15.5345 6.64193 15.7144 6.96479 15.9951 7.17781C16.2757 7.39083 16.6251 7.4699 17.3241 7.62805L17.9605 7.77203C20.4201 8.32856 21.65 8.60682 21.9426 9.54773C22.2352 10.4886 21.3968 11.4691 19.7199 13.4299L19.2861 13.9372C18.8096 14.4944 18.5713 14.773 18.4641 15.1177C18.357 15.4624 18.393 15.8341 18.465 16.5776L18.5306 17.2544C18.7841 19.8706 18.9109 21.1787 18.1449 21.7602C17.3788 22.3417 16.2273 21.8115 13.9243 20.7512L13.3285 20.4768C12.6741 20.1755 12.3469 20.0248 12 20.0248C11.6531 20.0248 11.3259 20.1755 10.6715 20.4768L10.0757 20.7512C7.77268 21.8115 6.62118 22.3417 5.85515 21.7602C5.08912 21.1787 5.21588 19.8706 5.4694 17.2544L5.53498 16.5776C5.60703 15.8341 5.64305 15.4624 5.53586 15.1177C5.42868 14.773 5.19043 14.4944 4.71392 13.9372L4.2801 13.4299C2.60325 11.4691 1.76482 10.4886 2.05742 9.54773C2.35002 8.60682 3.57986 8.32856 6.03954 7.77203L6.67589 7.62805C7.37485 7.4699 7.72433 7.39083 8.00494 7.17781C8.28555 6.96479 8.46553 6.64194 8.82547 5.99623L9.15316 5.40838Z"/>
                                    </svg>
                                </label>
                            <input type="radio" name="rating" value="4" id="star_<?php echo $заявление['ID']; ?>_4">
                                <label for="star_<?php echo $заявление['ID']; ?>_4">
                                    <svg style="cursor: pointer" width="30px" height="30px" viewBox="0 0 24 24">
                                        <path class="starIcon" d="M9.15316 5.40838C10.4198 3.13613 11.0531 2 12 2C12.9469 2 13.5802 3.13612 14.8468 5.40837L15.1745 5.99623C15.5345 6.64193 15.7144 6.96479 15.9951 7.17781C16.2757 7.39083 16.6251 7.4699 17.3241 7.62805L17.9605 7.77203C20.4201 8.32856 21.65 8.60682 21.9426 9.54773C22.2352 10.4886 21.3968 11.4691 19.7199 13.4299L19.2861 13.9372C18.8096 14.4944 18.5713 14.773 18.4641 15.1177C18.357 15.4624 18.393 15.8341 18.465 16.5776L18.5306 17.2544C18.7841 19.8706 18.9109 21.1787 18.1449 21.7602C17.3788 22.3417 16.2273 21.8115 13.9243 20.7512L13.3285 20.4768C12.6741 20.1755 12.3469 20.0248 12 20.0248C11.6531 20.0248 11.3259 20.1755 10.6715 20.4768L10.0757 20.7512C7.77268 21.8115 6.62118 22.3417 5.85515 21.7602C5.08912 21.1787 5.21588 19.8706 5.4694 17.2544L5.53498 16.5776C5.60703 15.8341 5.64305 15.4624 5.53586 15.1177C5.42868 14.773 5.19043 14.4944 4.71392 13.9372L4.2801 13.4299C2.60325 11.4691 1.76482 10.4886 2.05742 9.54773C2.35002 8.60682 3.57986 8.32856 6.03954 7.77203L6.67589 7.62805C7.37485 7.4699 7.72433 7.39083 8.00494 7.17781C8.28555 6.96479 8.46553 6.64194 8.82547 5.99623L9.15316 5.40838Z"/>
                                    </svg>
                                </label>
                            <input type="radio" name="rating" value="5" id="star_<?php echo $заявление['ID']; ?>_5">
                                <label for="star_<?php echo $заявление['ID']; ?>_5">
                                    <svg style="cursor: pointer" width="30px" height="30px" viewBox="0 0 24 24">
                                        <path class="starIcon" d="M9.15316 5.40838C10.4198 3.13613 11.0531 2 12 2C12.9469 2 13.5802 3.13612 14.8468 5.40837L15.1745 5.99623C15.5345 6.64193 15.7144 6.96479 15.9951 7.17781C16.2757 7.39083 16.6251 7.4699 17.3241 7.62805L17.9605 7.77203C20.4201 8.32856 21.65 8.60682 21.9426 9.54773C22.2352 10.4886 21.3968 11.4691 19.7199 13.4299L19.2861 13.9372C18.8096 14.4944 18.5713 14.773 18.4641 15.1177C18.357 15.4624 18.393 15.8341 18.465 16.5776L18.5306 17.2544C18.7841 19.8706 18.9109 21.1787 18.1449 21.7602C17.3788 22.3417 16.2273 21.8115 13.9243 20.7512L13.3285 20.4768C12.6741 20.1755 12.3469 20.0248 12 20.0248C11.6531 20.0248 11.3259 20.1755 10.6715 20.4768L10.0757 20.7512C7.77268 21.8115 6.62118 22.3417 5.85515 21.7602C5.08912 21.1787 5.21588 19.8706 5.4694 17.2544L5.53498 16.5776C5.60703 15.8341 5.64305 15.4624 5.53586 15.1177C5.42868 14.773 5.19043 14.4944 4.71392 13.9372L4.2801 13.4299C2.60325 11.4691 1.76482 10.4886 2.05742 9.54773C2.35002 8.60682 3.57986 8.32856 6.03954 7.77203L6.67589 7.62805C7.37485 7.4699 7.72433 7.39083 8.00494 7.17781C8.28555 6.96479 8.46553 6.64194 8.82547 5.99623L9.15316 5.40838Z"/>
                                    </svg>
                                </label>
                        </div>
                            <button type="button" id="submitRating" onclick="rateFunction(this)">Оценить</button>
                        </form>
                        <?php 
                    }
                    ?>


                    </div>
                    <?php
                }
            }

            $conn->close();
            ?>
        </div>

    </div>
<div id="i1">Сохранено</div>
<div id="i2">Ошибка при создании сообщения: </div>
<div id="i3">Ошибка при создании беседы: </div>
<div id="i4">Ошибка при создании заявки: </div>
</body>
<script src="scripts.js">
</script>
<script src="chat.js"></script>
</html>
