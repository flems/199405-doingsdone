<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db.php');

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
if($link) {
    mysqli_set_charset($link, "utf-8");
}

$project_list = [];
$task_list = [];
$all_tasks = [];
$show_complete_tasks = 1;
$page_content = '';
$user_id = '';
$user_id = 1;

?>
