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
function getInfo($link, $sql, $user_id){
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
        move_uploaded_file($file['tmp_name'], $file_path . $filne_name);
        $sql .= ", `file_name` = '$original_name', `file_url` = '$file_url'";
    }

    if (!$res = mysqli_query($link, $sql)) {
        $error['add_task'] = mysqli_error($link);
    } else {
        header("Location: /");
    }
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
    foreach ($project_list as $project) {
        $projects[] = $project['id'];
    }
    if(!in_array($formData['project'], $projects)){
        $errors['project'] = 'Данного проекта не существует';
    }
    //проверка даты
    if(!empty($formData['date'])){
        if(!validateDate($formData['date'])){
            $errors['date'] = 'Неверный формат даты';
        }
    }
    return $errors;
}
