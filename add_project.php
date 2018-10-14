<?php
error_reporting(E_ALL);
require_once($_SERVER['DOCUMENT_ROOT'].'/config/init.php');

//перенаправляет на страницу для гостей если пользователь не авторизован
if(!isset($_SESSION['user'])){
    header("Location: /guest.php");
    exit();
}

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


$formData = [];
$form_errors = [];

//получаем список проектов
$sql = "SELECT `id`, `p_name`, `user_id` FROM projects WHERE `user_id` = '$user_id'";
$projects_array = getInfo($link, $sql, $user_id);
isset($projects_array['error']) ? $error['project_list'] = mysqli_error($link) : $project_list = $projects_array['result'];

//обрабатываем данные с формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formData = $_POST['project'];
    $required_fields = ['name'];
    $form_errors = validateFormAddProject($_POST['project'], $required_fields, $project_list);
    if(empty($form_errors)) {
        // addTask($_POST['project'], $_FILES['preview'], $user_id, $link);
        $result = addProject($_POST['project'], $user_id, $link);
        if(isset($result['error'])){
            $error['add_project'] = $result['error'];
        } else {
            header("Location: /");
        }
    }
}

//подключаем компонент страницы
if(isset($error)) {
    $page_content = include_template('error.php', ['error' => $error]);
    $page = include_template('layout.php', [
        'page_content' => $page_content,
        'user_id' => $user_id,
        'user' => $user,
        'page_title' => "Дела в порядке",
      ]
    );
} else {
    $page_content = include_template('add_project.php', [
        'project_list' => $project_list,
        'formData' => $formData,
        'form_errors' => $form_errors,
    ]);
    $page = include_template('layout.php', [
        'page_content' => $page_content,
        'page_title' => "Дела в порядке",
        'project_list' => $project_list,
        'all_tasks' => $all_tasks,
        'user_id' => $user_id,
        'user' => $user,
        'guest' => $guest,
      ]
    );
}


print_r($page);
