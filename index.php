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
      ]
    );
} else {


    //Обновление статуса задачи
    if (isset($_GET['task_id']) && isset($_GET['task_id'])) {

        $data['task_id'] = $_GET['task_id'];
        $data['task_ready'] = $_GET['check'];

        $result = updateTask($data, $user_id, $link);
        if(isset($result['error'])){
            $error['update_task'] = $result['error'];
        } else {
            header("Location: /");
        }
    }

    //Фильтры задач
    $filter = $_GET['filter'] ?? '';
    $project_id = $_GET['project'] ?? '';

    //получаем список проектов
    $sql = "SELECT `id`, `p_name`, `user_id` FROM projects WHERE `user_id` = '$user_id'";
    $projects_array = getInfo($link, $sql, $user_id);
    isset($projects_array['error']) ? $error['project_list'] = mysqli_error($link) : $project_list = $projects_array['result'];

    //получаем список всех задач c учетом id пользователя
    $sql = "SELECT * FROM tasks WHERE `user_id` = '$user_id'";
    $all_tasks_array = getInfo($link, $sql, $user_id);
    isset($all_tasks_array['error']) ? $error['all_tasks'] = mysqli_error($link) : $all_tasks = $all_tasks_array['result'];

    //список задач для пользователя с учетом id проекта и учетом фильтра по дате
    $sql = "SELECT * FROM tasks WHERE `user_id` = '$user_id'";
    if (isset($_GET['project'])) {
      $sql .= "&& `project_id` = '$project_id'";
    }
    if (isset($_GET['filter'])) {
       switch ($filter) {
        case 'today':
          $sql .= "&& `execute_date` = CURDATE()";
          break;
        case 'tomorrow':
          $sql .= "&& `execute_date` = CURDATE() + INTERVAL 1 DAY";
          break;
        case 'expired':
          $sql .= "&& `execute_date` < CURDATE()";
          break;
      }
    }
    $task_list_array = getInfo($link, $sql, $user_id);
    isset($task_list_array['error']) ? $error['task_list'] = mysqli_error($link) : $task_list = $task_list_array['result'];

    //подключаем компонент страницы
    if(isset($error)) {
        $page_content = include_template('error.php', ['error' => $error]);
        $page = include_template('layout.php', [
            'page_content' => $page_content,
            'page_title' => "Дела в порядке",
            'guest' => $guest,
            'user_id' => $user_id,
            'user' => $user,
          ]
        );
    } else {
        $page_content = include_template('index.php', [
            'task_list' => $task_list,
            'show_complete_tasks' => $show_complete_tasks
        ]);
        $page = include_template('layout.php', [
            'page_content' => $page_content,
            'page_title' => "Дела в порядке",
            'project_list' => $project_list,
            'task_list' => $task_list,
            'all_tasks' => $all_tasks,
            'show_complete_tasks' => $show_complete_tasks,
            'user_id' => $user_id,
            'user' => $user,
            'guest' => $guest,
          ]
        );
    }

    // Если параметр запроса отсутствует, либо если по этому id не нашли ни одной записи, то вместо содержимого страницы возвращать код ответа 404.
    if(isset($_GET['project']) && !isset($error)){
        $project_isset = false;
        foreach ($project_list as $key => $project) {
            if($_GET['project'] == $project['id']) {
                $project_isset = true;
            }
        }
        if(!$project_isset || $project_id == '') {
            header("HTTP/1.1 404 Not Found");
            die();
        }
    }

}

print_r($page);
