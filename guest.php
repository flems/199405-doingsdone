<?php
error_reporting(E_ALL);
require_once($_SERVER['DOCUMENT_ROOT'].'/config/init.php');

//перенаправляет на главную страницу если пользователь авторизован
if(isset($_SESSION['user'])){
    header("Location: /");
    exit();
}

$guest = true;

if (!$link) {
    $error['error_connect'] = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
    $page = include_template('layout.php', [
        'page_content' => $page_content,
        'page_title' => "Дела в порядке",
        'user_id' => $user_id,
        'user' => $user,
        'guest' => $guest,
      ]
    );
    print($page);
    exit();
}


$page_content = include_template('guest.php', []);
$page = include_template('layout.php', [
    'page_content' => $page_content,
    'page_title' => "Дела в порядке",
    'project_list' => $project_list,
    'task_list' => $task_list,
    'all_tasks' => $all_tasks,
    'show_complete_tasks' => $show_complete_tasks,
    'user_id' => $user_id,
    'guest' => $guest,
    'user' => $user,
  ]
);



print_r($page);
