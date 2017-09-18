<section class="lot-item container">
  <h2><?=$lot['title']?></h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <img src="<?=$lot['image']?>" width="730" height="548" alt="Фото лота">
      </div>
      <p class="lot-item__category">Категория: <span><?=$lot['category']?></span></p>
      <p class="lot-item__description"><?=$lot['description']?></p>
    </div>
    <div class="lot-item__right">
      <?php if ($_SESSION['user']): ?>
        <div class="lot-item__state">
          <div class="lot-item__timer timer">
            <?=getLotRemainingTime($lot['end_date']);?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?=$lot['cost']?></span>
            </div>
            <div class="lot-item__min-cost">
              Мин. ставка <span><?=$lot['step']?> р</span>
            </div>
          </div>
          <?php if ( !$already_bet ): ?>
            <form class="lot-item__form" action="lot.php?id=<?=$_GET['id'];?>" method="post">
              <p class="lot-item__form-item form__item <?php echo in_array('price', $errors) ? 'form__item--invalid' : '';?>">
                <label for="price">Ваша ставка</label>
                <input id="price" type="number" name="form[price]" placeholder="12 000" value="<?=$_POST['form']['price'];?>">
              </p>
              <button type="submit" class="button">Сделать ставку</button>
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
                <td class="history__time"><?=getRelativeLotTime($bet['created_time'])?></td>
              </tr>
            <?php endforeach;?>
          </table>
      </div>
      <?php endif;?>
    </div>
  </div>
</section>