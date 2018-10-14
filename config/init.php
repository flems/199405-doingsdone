<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db.php');

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
if($link) {
    mysqli_set_charset($link, "utf-8");
}

$project_list = [];
$task_list = [];
$all_tasks = [];
$show_complete_tasks = 0;
$page_content = '';
$user_id = '';
// $user_id = 1;
$guest = false;
$user = [];
if(isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
    $user = $_SESSION['user'];
    $show_complete_tasks = $_SESSION['user']['show_completed'];
}

?>
