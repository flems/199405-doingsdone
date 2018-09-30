<?php
error_reporting(E_ALL);
require_once($_SERVER['DOCUMENT_ROOT'].'/config/init.php');


if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
} else {
    //получаем список проектов
    $sql = "SELECT `id`, `name` FROM projects WHERE `user_id` = '$user_id'";
    if (!$res = mysqli_query($link, $sql)) {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    } else {
        $project_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    //получаем список задач
    $sql = "SELECT * FROM tasks projects WHERE `user_id` = '$user_id'";
    if (!$res = mysqli_query($link, $sql)) {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    } else {
        $task_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $page_content = include_template('index.php', [
            'task_list' => $task_list,
            'show_complete_tasks' => $show_complete_tasks
        ]);
    }
}

$page = include_template('layout.php', [
    'page_content' => $page_content,
    'page_title' => "Дела в порядке",
    'project_list' => $project_list,
    'task_list' => $task_list,
    'show_complete_tasks' => $show_complete_tasks,
  ]
);
print_r($page);
