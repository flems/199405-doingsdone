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

    //обрабатываем данные с формы
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $formData = $_POST['user'];
        $required_fields = ['name', 'email', 'password'];
        $form_errors = validateRegistrForm($formData, $required_fields, $link);
        if(empty($form_errors)) {
            $result = addUser($formData, $link);
            if(isset($result['error'])){
                $error['add_user'] = $result['error'];
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
            'page_title' => "Дела в порядке",
            'user_id' => $user_id,
          ]
        );
    } else {
        $page_content = include_template('register.php', [
            'formData' => $formData,
            'form_errors' => $form_errors,
        ]);
        $page = include_template('layout.php', [
            'page_content' => $page_content,
            'page_title' => "Дела в порядке",
            'project_list' => $project_list,
            'all_tasks' => $all_tasks,
            'user_id' => $user_id,
          ]
        );
    }





}

print_r($page);
