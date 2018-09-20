<?php
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'].'/config/data.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/functions.php');


$page_content = include_template('index.php', ['task_list' => $task_list, 'show_complete_tasks' => $show_complete_tasks]);

$page = include_template(
  'layout.php',
  [
    'page_content' => $page_content,
    'page_title' => "Дела в порядке",
    'project_list' => $project_list,
    'task_list' => $task_list,
    'show_complete_tasks' => $show_complete_tasks,
  ]
);
print_r($page);
