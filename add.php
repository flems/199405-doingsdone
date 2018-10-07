<?php
error_reporting(E_ALL);
require_once($_SERVER['DOCUMENT_ROOT'].'/config/init.php');

if (!$link) {
    $error['error_connect'] = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
    $page = include_template('layout.php', [
        'page_content' => $page_content,
        'page_title' => "Дела в порядке",
      ]
    );
} else {

    $formData = [];
    $form_errors = [];

    //получаем список проектов
    $sql = "SELECT `id`, `p_name`, `user_id` FROM projects WHERE `user_id` = '$user_id'";
    $projects_array = getInfo($link, $sql, $user_id);
    isset($projects_array['error']) ? $error['project_list'] = mysqli_error($link) : $project_list = $projects_array['result'];

    //получаем список задач c учетом id пользователя
    $sql = "SELECT * FROM tasks WHERE `user_id` = '$user_id'";
    $all_tasks_array = getInfo($link, $sql, $user_id);
    isset($all_tasks_array['error']) ? $error['all_tasks'] = mysqli_error($link) : $all_tasks = $all_tasks_array['result'];

    //обрабатываем данные с формы
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $formData = $_POST['project'];
        $form_errors = [];
        $required_fields = ['name', 'project'];
        $form_errors = validateForm($_POST['project'], $required_fields, $project_list);
        if(empty($form_errors)) {
            addTask($_POST['project'], $_FILES['preview'], $user_id, $link);
        }
    }

    //подключаем компонент страницы
    if(isset($error)) {
        $page_content = include_template('error.php', ['error' => $error]);
        $page = include_template('layout.php', [
            'page_content' => $page_content,
            'page_title' => "Дела в порядке",
          ]
        );
    } else {
        $page_content = include_template('add.php', [
            'project_list' => $project_list,
            'formData' => $formData,
            'form_errors' => $form_errors,
        ]);
        $page = include_template('layout.php', [
            'page_content' => $page_content,
            'page_title' => "Дела в порядке",
            'project_list' => $project_list,
            'all_tasks' => $all_tasks,
          ]
        );
    }





}

print_r($page);
