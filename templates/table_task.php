<?
$show_complete_tasks = rand(0, 1);
?>
<table class="tasks">
  <?php foreach ($task_list as $key => $task): ?>
    <?php if ($show_complete_tasks === 1 || $task['status'] === 'Нет'): ?>
      <tr class="tasks__item task <?php if($task['status'] === 'Да'):?>task--completed<?php endif;?>">
        <td class="task__select">
          <label class="checkbox task__checkbox">
            <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
            <span class="checkbox__text"><?=$task['name']?></span>
          </label>
        </td>
        <td class="task__date"><?=$task['execute_date']?></td>
      </tr>
    <?php endif; ?>
  <?php endforeach; ?>
</table>