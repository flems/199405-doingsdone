<?php
error_reporting(E_ALL);
require_once($_SERVER['DOCUMENT_ROOT'].'/config/init.php');

//перенаправляет на главную страницу если пользователь авторизован
if(isset($_SESSION['user'])){
    header("Location: /");
    exit();
}

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
        $formData = $_POST['auth'];
        $required_fields = ['email', 'password'];
        $result = validateAuthForm($formData, $required_fields, $link);
        $form_errors = $result['errors'] ?? '';
        if ($form_errors === '') {
            $_SESSION['user'] = $result['user'];
            header("Location: /");
        }
    }

    //подключаем компонент страницы
    if(isset($error)) {
        $page_content = include_template('error.php', ['error' => $error]);
        $page = include_template('layout.php', [
            'page_content' => $page_content,
            'page_title' => "Дела в порядке",
            'user_id' => $user_id,
            'user' => $user,
          ]
        );
    } else {
        $page_content = include_template('auth.php', [
            'formData' => $formData,
            'form_errors' => $form_errors,
        ]);
        $page = include_template('layout.php', [
            'page_content' => $page_content,
            'page_title' => "Дела в порядке",
            'project_list' => $project_list,
            'all_tasks' => $all_tasks,
            'user_id' => $user_id,
            'guest' => $guest,
            'user' => $user,
          ]
        );
    }
}



print_r($page);
