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
