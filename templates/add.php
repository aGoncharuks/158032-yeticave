<form class="form form--add-lot container <?php echo count($errors) ? 'form--invalid' : '';?>" action="add.php" method="post" enctype="multipart/form-data">
  <h2>Добавление лота</h2>
  <div class="form__container-two">
    <div class="form__item <?php echo in_array('title', $errors) ? 'form__item--invalid' : '';?>">
      <label for="lot-name">Наименование</label>
      <input id="lot-name" type="text" name="form[title]" placeholder="Введите наименование лота" value="<?=$_POST['form']['title'] ?? '';?>">
      <span class="form__error">Обязательное поле</span>
    </div>
    <div class="form__item  <?php echo in_array('category', $errors) ? 'form__item--invalid' : '';?>">
      <label for="category">Категория</label>
      <select id="category" name="form[category]" value="<?=$_POST['form']['category'] ?? '';?>">
        <?php foreach ($categories as $category): ?>
          <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
        <?php endforeach; ?>
      </select>
      <span class="form__error">Обязательное поле</span>
    </div>
  </div>
  <div class="form__item form__item--wide  <?php echo in_array('description', $errors) ? 'form__item--invalid' : '';?>">
    <label for="message">Описание</label>
    <textarea id="message" name="form[description]" placeholder="Напишите описание лота"><?=htmlspecialchars($_POST['form']['description'] ?? '') ;?></textarea>
    <span class="form__error">Обязательное поле</span>
  </div>
  <div class="form__item form__item--file <?php echo isset($_SESSION['image']) && !in_array('image', $errors) ? 'form__item--uploaded' : ''; echo in_array('image', $errors) ? ' form__item--invalid' : '';?>">
    <label>Изображение</label>
    <div class="preview">
      <div class="preview__img">
        <img src="<?=isset($_SESSION['image']) ? '../img/'.$_SESSION['image']['name'] : '';?>"  width="113" height="113" alt="Изображение лота">
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
  <div class="form__container-three">
    <div class="form__item form__item--small <?php echo in_array('cost', $errors) ? 'form__item--invalid' : '';?>">
      <label for="lot-rate">Начальная цена</label>
      <input id="lot-rate" name="form[cost]" placeholder="0" min="1" value="<?=$_POST['form']['cost'] ?? '';?>">
      <span class="form__error">Обязательное поле, только числовые значения больше нуля</span>
    </div>
    <div class="form__item form__item--small <?php echo in_array('step', $errors) ? 'form__item--invalid' : '';?>">
      <label for="lot-step">Шаг ставки</label>
      <input id="lot-step" name="form[step]" placeholder="0" min="1" value="<?=$_POST['form']['step'] ?? '';?>">
      <span class="form__error">Обязательное поле, только числовые значения больше нуля</span>
    </div>
    <div class="form__item <?php echo in_array('end_date', $errors) ? 'form__item--invalid' : '';?>">
      <label for="lot-date">Дата завершения</label>
      <input class="form__input-date" id="lot-date" type="date" name="form[end_date]" placeholder="дд/мм/гггг" value="<?=$_POST['form']['end_date'] ?? '';?>">
      <span class="form__error">Обязательное поле</span>
    </div>
  </div>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <?php if ($info_msg): ?>
    <span class="form__error form__error--bottom"><?=$info_msg?></span>
  <?php endif;?>

  <button type="submit" class="button">Добавить лот</button>
</form>