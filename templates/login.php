  <nav class="nav">
    <ul class="nav__list container">
      <li class="nav__item">
        <a href="all-lots.html">Доски и лыжи</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Крепления</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Ботинки</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Одежда</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Инструменты</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Разное</a>
      </li>
    </ul>
  </nav>
  <form class="form container <?php echo count($errors['required']) || count($errors['custom']) ? 'form--invalid' : '';?>" action="login.php" method="post">
    <h2>Вход</h2>
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
      <?php endif; ?>    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Войти</button>
  </form>

