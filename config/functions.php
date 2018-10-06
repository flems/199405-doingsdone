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
