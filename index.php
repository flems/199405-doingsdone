<?php
error_reporting(E_ALL);
require_once($_SERVER['DOCUMENT_ROOT'].'/config/init.php');

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
} else {
    $project_id = $_GET['project'] ?? '';

    //получаем список проектов
    // $sql = "SELECT `id`, `p_name`, `user_id` "
    //      . "FROM projects WHERE `user_id` = '$user_id'";
    // if (!$res = mysqli_query($link, $sql)) {
    //     $error = mysqli_error($link);
    //     $page_content = include_template('error.php', ['error' => $error]);
    // } else {
    //     $project_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
    //     echo '<pre>';
    //     print_r($project_list);
    //     echo '</pre>';
    // }
    $sql = 'SELECT project_id, projects.id, p_name, projects.user_id, COUNT(*) count FROM tasks '
         . 'JOIN projects '
         . 'ON project_id = projects.id '
         . 'WHERE projects.user_id = 1 '
         . 'GROUP BY project_id';

    if (!$res = mysqli_query($link, $sql)) {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    } else {
        $project_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    //получаем список задач
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
    if(isset($_GET['project']) && $project_id = '' || isset($_GET['project']) && !$task_list) {
        header("HTTP/1.1 404 Not Found");
        die();
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
