<h2 class="content__main-heading">Список задач</h2>
<form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
  <nav class="tasks-switch">
    <a href="/<?if(isset($_GET['project'])):?>?project=<?=$_GET['project']?><?endif;?>" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
    <a href="/?<?if(isset($_GET['project'])):?>project=<?=$_GET['project']?>&<?endif;?>filter=today" class="tasks-switch__item">Повестка дня</a>
    <a href="/?<?if(isset($_GET['project'])):?>project=<?=$_GET['project']?>&<?endif;?>filter=tomorrow" class="tasks-switch__item">Завтра</a>
    <a href="/?<?if(isset($_GET['project'])):?>project=<?=$_GET['project']?>&<?endif;?>filter=expired" class="tasks-switch__item">Просроченные</a>
  </nav>

  <label class="checkbox">
    <input class="checkbox__input visually-hidden show_completed"
      <?php if ($show_complete_tasks): ?>checked<?php endif; ?>
    type="checkbox">
    <span class="checkbox__text">Показывать выполненные</span>
  </label>
</div>

<?=include_template('table_task.php', ['task_list' => $task_list, 'show_complete_tasks' => $show_complete_tasks])?>
