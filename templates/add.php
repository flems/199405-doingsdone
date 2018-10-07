<h2 class="content__main-heading">Добавление задачи</h2>
<form class="form"  action="add.php" method="post" enctype="multipart/form-data">
    <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>
        <input class="form__input<?php if(isset($form_errors['name'])):?> form__input--error<?endif;?>" type="text" name="project[name]" id="name"
        value="<?php if(isset($formData['name'])):?><?=$formData['name']?><?endif;?>" placeholder="Введите название">
        <p class="form__message">
            <span class="form__message error-message"><?php if(isset($form_errors['name'])):?><?=$form_errors['name']?><?endif;?></span>
        </p>
    </div>

    <div class="form__row">
        <label class="form__label" for="project">Проект <sup>*</sup></label>
        <select class="form__input form__input--select<?php if(isset($form_errors['project'])):?> form__input--error<?endif;?>" name="project[project]" id="project">
            <?php foreach ($project_list as $key => $project): ?>
                <option
                    value="<?=$project['id']?>"
                    <?php if(isset($formData['project']) && $formData['project'] === $project['id']):?> selected<?endif;?>
                >
                    <?=$project['p_name']?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="form__message">
            <span class="form__message error-message"><?php if(isset($form_errors['project'])):?><?=$form_errors['project']?><?endif;?></span>
        </p>
    </div>

    <div class="form__row">
        <label class="form__label" for="date">Дата выполнения</label>

        <input class="form__input form__input--date <?php if(isset($form_errors['date'])):?> form__input--error<?endif;?>" type="date" name="project[date]" id="date" value="<?php if(isset($formData['date'])):?><?=$formData['date']?><?endif;?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
        <p class="form__message">
            <span class="form__message error-message"><?php if(isset($form_errors['date'])):?><?=$form_errors['date']?><?endif;?></span>
        </p>
    </div>

    <div class="form__row">
        <label class="form__label" for="preview">Файл</label>

        <div class="form__input-file">
          <input class="visually-hidden" type="file" name="preview" id="preview" value="">

          <label class="button button--transparent" for="preview">
            <span>Выберите файл</span>
          </label>
        </div>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
