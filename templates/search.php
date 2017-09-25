<section class="lots">
  <h2>Результаты поиска по запросу «<span><?= htmlspecialchars($searchTerm); ?></span>»</h2>
  <ul class="lots__list">
    <?php foreach ($lots as $key => $lot): ?>
      <li class="lots__item lot">
        <div class="lot__image">
          <img src="<?= $lot['image']; ?>" width="350" height="260" alt="Сноуборд">
        </div>
        <div class="lot__info">
          <span class="lot__category"><?= $lot['category']; ?></span>
          <h3 class="lot__title">
            <a class="text-link" href="<?= "lot.php?id={$lot['id']}"; ?>"><?= htmlspecialchars($lot['title']); ?></a>
          </h3>
          <div class="lot__state">
            <div class="lot__rate">
              <span class="lot__amount">Стартовая цена</span>
              <span class="lot__cost">><?= htmlspecialchars($lot['cost']); ?><b class="rub">р</b></span>
            </div>
            <div class="lot__timer lot__timer--card timer">
              <?=getLotRemainingTime($lot['end_date']);?>
            </div>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
<?=$pagination;?>