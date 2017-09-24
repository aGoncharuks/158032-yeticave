<form class="form container <?php echo count($errors['required']) || count($errors['custom']) ? 'form--invalid' : '';?>" action="login.php" method="post">
  <h2>Вход</h2>
  <?php if ($_GET['from_signup']): ?>
    <h4>Теперь вы можете войти, используя свой email и пароль</h4>
  <?php endif; ?>
  <div class="form__item <?php echo in_array('email', $errors['required']) ||
  in_array('email', $errors['custom']) ? 'form__item--invalid' : '';?>">
    <label for="email">E-mail*</label>
    <input id="email" type="text" name="form[email]" placeholder="Введите e-mail" value="<?=$_POST['form']['email'];?>">
    <?php if ( in_array('email', $errors['required']) ): ?>
      <span class="form__error">Введите e-mail</span>
    <?php elseif ( in_array('email', $errors['custom']) ): ?>
      <span class="form__error">Вы ввели неверный e-mail</span>
    <?php endif; ?>
  </div>
  <div class="form__item form__item--last <?php echo in_array('password', $errors['required']) || in_array('password', $errors['custom']) ? 'form__item--invalid' : '';?>">
    <label for="password">Пароль*</label>
    <input id="password" type="password" name="form[password]" placeholder="Введите пароль" value="<?=$_POST['form']['password'];?>">
    <?php if ( in_array('password', $errors['required']) ): ?>
      <span class="form__error">Введите пароль</span>
    <?php elseif ( in_array('password', $errors['custom']) ): ?>
      <span class="form__error">Вы ввели неверный пароль</span>
    <?php endif; ?>
  </div>
  <button type="submit" class="button">Войти</button>
</form>
