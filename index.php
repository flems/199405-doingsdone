<?php
error_reporting(E_ALL);
require_once($_SERVER['DOCUMENT_ROOT'].'/config/init.php');
if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
} else {
    $project_id = $_GET['project'] ?? '';

    //получаем список проектов
    $sql = "SELECT `id`, `p_name`, `user_id` "
         . "FROM projects WHERE `user_id` = '$user_id'";
    if (!$res = mysqli_query($link, $sql)) {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    } else {
        $project_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    //получаем список задач c учетом id пользователя
    $sql = "SELECT * FROM tasks WHERE `user_id` = '$user_id'";
    if (!$res = mysqli_query($link, $sql)) {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    } else {
        $all_tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    //список задач для пользователя с учетом id проекта
    $sql = "SELECT * FROM tasks WHERE `user_id` = '$user_id'";
    if (isset($_GET['project'])) {
       $sql .= "&& `project_id` = '$project_id'";
    }
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

    // Если параметр запроса отсутствует, либо если по этому id не нашли ни одной записи, то вместо содержимого страницы возвращать код ответа 404.
    if(isset($_GET['project']) &&  $project_id == ''){
        header("HTTP/1.1 404 Not Found");
        die();
    }
}
$page = include_template('layout.php', [
    'page_content' => $page_content,
    'page_title' => "Дела в порядке",
    'project_list' => $project_list,
    'task_list' => $task_list,
    'all_tasks' => $all_tasks,
    'show_complete_tasks' => $show_complete_tasks,
  ]
);
print_r($page);
