<h2 class="content__main-heading">Вход на сайт</h2>
<form class="form" action="auth.php" method="post">
    <div class="form__row">
        <label class="form__label" for="email">E-mail <sup>*</sup></label>
        <input class="form__input<?php if(isset($form_errors['email'])):?> form__input--error<?endif;?>" type="text" name="auth[email]" id="email" value="<?php if(isset($formData['email'])):?><?=$formData['email']?><?endif;?>" placeholder="Введите e-mail">
        <p class="form__message"><?php if(isset($form_errors['email'])):?><?=$form_errors['email']?><?endif;?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="password">Пароль <sup>*</sup></label>

        <input class="form__input<?php if(isset($form_errors['password'])):?> form__input--error<?endif;?>" type="password" name="auth[password]" id="password" value="<?php if(isset($formData['password'])):?><?=$formData['password']?><?endif;?>" placeholder="Введите пароль">
        <p class="form__message"><?php if(isset($form_errors['password'])):?><?=$form_errors['password']?><?endif;?></p>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Войти">
    </div>
</form>
