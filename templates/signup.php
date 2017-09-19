<form class="form container <?php echo count($errors['required']) || count($errors['custom']) ? 'form--invalid' : '';?>" action="signup.php" method="post" enctype="multipart/form-data">
  <h2>Регистрация нового аккаунта</h2>
  <div class="form__item <?php echo in_array('email', $errors['required']) ||
  in_array('email', $errors['custom']) ? 'form__item--invalid' : '';?>">
    <label for="email">E-mail*</label>
    <input id="email" type="text" name="form[email]" placeholder="Введите e-mail" value="<?=$_POST['form']['email'];?>">
    <?php if ( in_array('email', $errors['required']) ): ?>
      <span class="form__error">Обязательное поле</span>
    <?php elseif ( in_array('email', $errors['custom']) ): ?>
      <span class="form__error">Вы ввели неверный e-mail</span>
    <?php elseif ( in_array('email_used', $errors['custom']) ): ?>
      <span class="form__error">Такой e-mail уже используется</span>
    <?php endif; ?>
  </div>
  <div class="form__item <?php echo in_array('password', $errors['required']) ||
  in_array('password', $errors['custom']) ? 'form__item--invalid' : '';?>">
    <label for="password">Пароль*</label>
    <input id="password" type="password" name="form[password]" placeholder="Введите пароль" value="<?=$_POST['form']['password'];?>">
    <?php if ( in_array('password', $errors['required']) ): ?>
      <span class="form__error">Обязательное поле</span>
    <?php elseif ( in_array('password', $errors['custom']) ): ?>
      <span class="form__error">Длина пароля должна быть не меньше 6 символов</span>
    <?php endif; ?>
  </div>
  <div class="form__item <?php echo in_array('name', $errors['required']) ? 'form__item--invalid' : '';?>">
    <label for="name">Имя*</label>
    <input id="name" type="text" name="form[name]" placeholder="Введите имя" value="<?=$_POST['form']['name'];?>">
    <span class="form__error">Обязательное поле</span>
  </div>
  <div class="form__item <?php echo in_array('contacts', $errors['required']) ? 'form__item--invalid' : '';?>">
    <label for="contacts">Контактные данные*</label>
    <textarea id="contacts" name="form[contacts]" placeholder="Напишите как с вами связаться"><?=$_POST['form']['contacts'];?></textarea>
    <span class="form__error">Обязательное поле</span>
  </div>
  <div class="form__item form__item--file form__item--last <?php echo isset($_SESSION['image']) && !in_array('image', $errors) ? 'form__item--uploaded' : ''; echo in_array('image', $errors['custom']) ? ' form__item--invalid' : '';?>">
    <label>Аватар</label>
    <div class="preview">
      <div class="preview__img">
        <img src="<?=isset($_SESSION['image']) ? '../img/'.$_SESSION['image']['name'] : '';?>"  width="113" height="113" alt="Аватар пользователя">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" type="file" id="image" name="image" value="">
      <label for="image">
        <span>+ Добавить</span>
      </label>
    </div>
    <span class="form__error">Обязательное поле, тип файла должен быть одним из: JPEG, PNG</span>
  </div>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <?php if ($info_msg): ?>
    <span class="form__error form__error--bottom"><?=$info_msg?></span>
  <?php endif;?>
  <button type="submit" class="button">Зарегистрироваться</button>
  <a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>