<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db.php');

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

$project_list = [];
$task_list = [];
$show_complete_tasks = 1;
$page_content = '';
$user_id = 1;

?>
