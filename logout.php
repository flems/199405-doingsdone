<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/init.php');

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}

header("Location: /");

?>
