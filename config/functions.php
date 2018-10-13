<?php
function include_template($name, $data)
{
  $name = 'templates/' . $name;
  $result = '';

  if (!file_exists($name)) {
    return $result;
  }

  ob_start();
  extract($data);
  require_once $name;

  $result = ob_get_clean();
  return $result;
}

function countTask($task_list, $project_id)
{
  $count = 0;
  foreach ($task_list as $key => $task) {
    if ($task['project_id'] === $project_id) {
      $count++;
    }
  }
  return $count;
}

//проверяет просроченная ли задача
function checkDates($date)
{
  $result = false;
  $secs_in_day = 24 * 60 * 60;
  $current_time = strtotime('now');
  $execute_date = strtotime($date);
  $time_before = $execute_date - $current_time;

  if ($execute_date) {
    $time_before <= $secs_in_day ? $result = true : $result = false;
  } else {
    $result = false;
  }

  return $result;
}

//функция запроса к бд
function getInfo($link, $sql, $user_id = '') {
    if (!$res = mysqli_query($link, $sql)) {
        // $error['project_list'] = mysqli_error($link);
        $dataArray['error'] = mysqli_error($link);
    } else {
        $dataArray['result'] = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $dataArray;
}

//Добавление новой задачи в бд
function addTask($formData, $file, $user_id, $link) {
    $result = [];
    $form_project = $formData['project'];
    $form_name = $formData['name'];
    $form_date = $formData['date'];

    $sql = "INSERT INTO tasks SET "
    . "`user_id` = '$user_id', `project_id` = '$form_project', `name` = '$form_name', `ready` = 0, `create_date` = CURDATE()";
    if($form_date != '') {
        $sql .= ", execute_date = date('$form_date')";
    }
    if($file['error'] == 0) {
        $original_name = $file['name'];
        $place = strripos($original_name, '.');
        $file_type = substr($original_name, $place);
        $filne_name = uniqid() . $file_type;
        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        $file_url = '/uploads/' . $filne_name;
        if(!file_exists($file_path)) {
            mkdir($file_path, 0777);
        }
        move_uploaded_file($file['tmp_name'], $file_path . $filne_name);
        $sql .= ", `file_name` = '$original_name', `file_url` = '$file_url'";
    }

    if (!$res = mysqli_query($link, $sql)) {
        $result['error'] = mysqli_error($link);
    }
    return $result;

}
//проверка даты
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
//Валидация формы добавления новой задачи
function validateForm ($formData, $required_fields, $project_list){
    $errors = [];
    //проверяем обязательный поля на заполненность
    foreach ($required_fields as $field) {
        if(empty($formData[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }
    //проверяем существование проекта в бд
    if (!empty($project_list)) {
      foreach ($project_list as $project) {
        $projects[] = $project['id'];
      }
      if(!in_array($formData['project'], $projects)){
        $errors['project'] = 'Данного проекта не существует';
      }
    }
    //проверка даты
    if(!empty($formData['date'])){
        if(!validateDate($formData['date'])){
            $errors['date'] = 'Неверный формат даты';
        }
    }
    return $errors;
}
//Валидация формы регистрации
function validateRegistrForm ($formData, $required_fields, $link){
    $errors = [];
    //проверяем обязательный поля на заполненность
    foreach ($required_fields as $field) {
        if(empty($formData[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }

    //проверяем на существование пользователя с таким email
    if(!isset($errors['email'])){
        $email = mysqli_real_escape_string($link, $formData['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($link, $sql);
        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с таким e-mail уже зарегистрирован';
        }
    }
    //проверяем на корректность email
    if(!isset($errors['email']) && !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'E-mail введён некорректно';
    }

    return $errors;
}
//добавление нового пользователя в бд
function addUser($formData, $link) {
    $result = [];
    $user_email = $formData['email'];
    $user_name = $formData['name'];
    $user_password = password_hash($formData['password'], PASSWORD_DEFAULT);


    $sql = "INSERT INTO users SET `email` = '$user_email', `password` = '$user_password', `name` = '$user_name'";

    if (!$res = mysqli_query($link, $sql)) {
        $result['error'] = mysqli_error($link);
    }
    return $result;
}

//функция валидации формы авторизации
function validateAuthForm ($formData, $required_fields, $link){
    $result = [];
    $email = mysqli_real_escape_string($link, $formData['email']);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($link, $sql);

    //проверяем обязательный поля на заполненность
    foreach ($required_fields as $field) {
        if(empty($formData[$field])) {
            $result['errors'][$field] = 'Поле не заполнено';
        }
    }
    //проверяем на корректность email
    if(!isset($result['errors']['email']) && !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)){
        $result['errors']['email'] = 'E-mail введён некорректно';
    }

    //проверяем существование пользователя с таким email в бд
    if(!isset($result['errors']['email'])){
        if (mysqli_num_rows($res) == 0) {
            $result['errors']['email'] = 'Пользователь с таким e-mail не зарегистрирован';
        }
    }

    //проверяем подходит ли пароль
    if(!isset($result['errors']['email']) && !isset($result['errors']['password'])){
        //проверяем пароль
        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
        if(!password_verify($formData['password'], $user['password'])) {
            $result['errors']['password'] = 'Неверный пароль';
        }
    }
    //если ошибок нет возвращаем id user
    if(!isset($result['errors'])) {
        $result['user'] = $user;
    }
    return $result;
}


//Валидация формы добавления проекта
function validateFormAddProject ($formData, $required_fields, $project_list){
    $errors = [];
    //проверяем обязательный поля на заполненность
    foreach ($required_fields as $field) {
        if(empty($formData[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }
    if(!isset($errors['project']) && !empty($project_list)) {
      //проверяем существование проекта в бд
      foreach ($project_list as $project) {
        $projects[] = $project['p_name'];
      }
      if(in_array($formData['name'], $projects)){
        $errors['name'] = 'Проект с таким названием уже существует';
      }
    }

    return $errors;
}



//Добавление новой задачи в бд
function addProject($formData, $user_id, $link) {
    $result = [];
    $form_name = $formData['name'];

    $sql = "INSERT INTO projects SET "
    . "`user_id` = '$user_id', `p_name` = '$form_name'";

    if (!$res = mysqli_query($link, $sql)) {
        $result['error'] = mysqli_error($link);
    }
    return $result;

}


//Обновление статуса задачи
function updateTask($data, $user_id, $link) {
    $result = [];
    $task_id = $data['task_id'];
    $task_ready = $data['task_ready'];

    $sql = "UPDATE `tasks` SET `ready` = $task_ready WHERE id = $task_id";

    if (!$res = mysqli_query($link, $sql)) {
        $result['error'] = mysqli_error($link);
    }
    return $result;

}
