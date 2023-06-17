<?php
    session_start();
    session_destroy();
    foreach ($_COOKIE as $name => $value) {
        setcookie($name, '', time() - 3600, "/");
    }
    foreach ($_COOKIE as $name => $value) {
        unset($_COOKIE[$name]);
    }
    
    header("Location: ../Вход/Страница входа.html");

?>