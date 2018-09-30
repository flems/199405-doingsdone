<?php foreach ($project_list as $key => $project):?>
    <li class="main-navigation__list-item">
        <a class="main-navigation__list-item-link" href="#"><?=$project['name']?></a>
        <span class="main-navigation__list-item-count"><?=countTask($task_list, $project['id'])?></span>
    </li>
<?php endforeach;?>
