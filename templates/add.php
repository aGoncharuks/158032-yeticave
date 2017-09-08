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
<form class="form form--add-lot container <?php echo count($errors) ? 'form--invalid' : '';?>" action="add.php" method="post" enctype="multipart/form-data">
  <h2>Добавление лота</h2>
  <div class="form__container-two">
    <div class="form__item <?php echo in_array('title', $errors) ? 'form__item--invalid' : '';?>">
      <label for="lot-name">Наименование</label>
      <input id="lot-name" type="text" name="title" placeholder="Введите наименование лота" value="<?=$_POST['title'];?>">
      <span class="form__error">Обязательное поле</span>
    </div>
    <div class="form__item  <?php echo in_array('category', $errors) ? 'form__item--invalid' : '';?>">
      <label for="category">Категория</label>
      <select id="category" name="category" value="<?=$_POST['category'];?>">
        <option>Доски и лыжи</option>
        <option>Крепления</option>
        <option>Ботинки</option>
        <option>Одежда</option>
        <option>Инструменты</option>
        <option>Разное</option>
      </select>
      <span class="form__error">Обязательное поле</span>
    </div>
  </div>
  <div class="form__item form__item--wide  <?php echo in_array('description', $errors) ? 'form__item--invalid' : '';?>">
    <label for="message">Описание</label>
    <textarea id="message" name="description" placeholder="Напишите описание лота"><?=$_POST['description'];?></textarea>
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
      <input id="lot-rate" name="cost" placeholder="0" min="1" value="<?=$_POST['cost'];?>">
      <span class="form__error">Обязательное поле, только числовые значения</span>
    </div>
    <div class="form__item form__item--small <?php echo in_array('min_bet', $errors) ? 'form__item--invalid' : '';?>">
      <label for="lot-step">Шаг ставки</label>
      <input id="lot-step" name="min_bet" placeholder="0" min="1" value="<?=$_POST['min_bet'];?>">
      <span class="form__error">Обязательное поле, только числовые значения</span>
    </div>
    <div class="form__item <?php echo in_array('end_date', $errors) ? 'form__item--invalid' : '';?>">
      <label for="lot-date">Дата завершения</label>
      <input class="form__input-date" id="lot-date" type="text" name="end_date" placeholder="20.05.2017" value="<?=$_POST['end_date'];?>">
      <span class="form__error">Обязательное поле</span>
    </div>
  </div>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <button type="submit" class="button">Добавить лот</button>
</form>