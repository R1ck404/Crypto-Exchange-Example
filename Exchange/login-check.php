<?php

if (!isset($_SESSION['isLoggedIn'])) {
    header('Location: ./login.php');
    die();
}

?>