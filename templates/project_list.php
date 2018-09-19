<?php foreach ($project_list as $key => $project):?>
    <li class="main-navigation__list-item">
        <a class="main-navigation__list-item-link" href="#"><?=$project?></a>
        <span class="main-navigation__list-item-count"><?=countTask($task_list, $project)?></span>
    </li>
<?php endforeach;?>
