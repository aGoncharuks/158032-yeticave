<section class="lot-item container">
  <h2><?=htmlspecialchars($lot['title'])?></h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <img src="<?=$lot['image']?>" width="730" height="548" alt="Фото лота">
      </div>
      <p class="lot-item__category">Категория: <span><?=$lot['category']?></span></p>
      <p class="lot-item__description"><?=htmlspecialchars($lot['description'])?></p>
      <p class="lot-item__category">Контакты: <span><?=htmlspecialchars($lot['contacts'])?></span></p>
    </div>
    <div class="lot-item__right">
      <?php if( isset($_SESSION['user']) ): ?>
        <div class="lot-item__state">
          <div class="lot-item__timer timer">
            <?=getLotRemainingTime($lot['end_date']);?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?=getLotMaxPrice($lot, $bets)?></span>
            </div>
            <div class="lot-item__min-cost">
              Мин. шаг ставки: <span><?=$lot['step']?> р</span>
            </div>
          </div>
          <?php if ( !$already_bet ): ?>
            <form class="lot-item__form flex-wrap <?php echo in_array('price', $errors) ? 'form__item--invalid' : '';?>" action="lot.php?id=<?=$_GET['id'];?>" method="post">
              <p class="lot-item__form-item form__item width_50 <?php echo in_array('price', $errors) ? 'form__item--invalid' : '';?>">
                <label for="price">Ваша ставка</label>
                <input id="price" type="number" name="form[price]" placeholder="12 000" value="<?=$_POST['form']['price'];?>">
              </p>
              <button type="submit" class="button width_50">Сделать ставку</button>
              <span class="form__error width_100">Ставка должна быть больше текущей цены</span>
            </form>
          <?php endif;?>
        </div>
      <?php endif;?>
      <?php if ( count($bets) ): ?>
      <div class="history">
          <h3>История ставок (<span><?=count($bets);?></span>)</h3>
          <table class="history__list">
            <?php foreach ($bets as $bet):?>
              <tr class="history__item">
                <td class="history__name"><?=$bet['author']?></td>
                <td class="history__price"><?=$bet['price']?> р</td>
                <td class="history__time"><?=getRelativeTime($bet['created_time'])?></td>
              </tr>
            <?php endforeach;?>
          </table>
      </div>
      <?php endif;?>
    </div>
  </div>
</section>