<?php foreach ($project_list as $key => $project):?>
    <li class="main-navigation__list-item">
        <a class="main-navigation__list-item-link" href="/?project=<?=$project['id']?>"><?=$project['p_name']?></a>
        <span class="main-navigation__list-item-count"><?=$project['count']?></span>
    </li>
<?php endforeach;?>
