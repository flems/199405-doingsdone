<h2 class="content__main-heading">Добавление проекта</h2>

<form class="form"  action="add_project.php" method="post">
  <div class="form__row">
    <label class="form__label" for="project_name">Название <sup>*</sup></label>

    <input class="form__input" type="text" name="project[name]" id="project_name" value="<?php if(isset($formData['name'])):?><?=$formData['name']?><?endif;?>" placeholder="Введите название проекта">
    <p class="form__message">
        <span class="form__message error-message"><?php if(isset($form_errors['name'])):?><?=$form_errors['name']?><?endif;?></span>
    </p>
  </div>

  <div class="form__row form__row--controls">
    <input class="button" type="submit" name="" value="Добавить">
  </div>
</form>
