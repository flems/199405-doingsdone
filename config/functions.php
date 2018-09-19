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

  // print_r($result);
  return $result;
}


function countTask($task_list, $project_name)
{
  $count = 0;
  foreach ($task_list as $key => $task) {
    if ($task['category'] === $project_name) {
      $count++;
    }
  }
  return $count;
}
