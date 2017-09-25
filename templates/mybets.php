<section class="rates container">
  <h2>Мои ставки</h2>
  <table class="rates__list">
    <?php foreach ($my_bets as $bet):?>
    <tr class="rates__item">
      <td class="rates__info">
        <div class="rates__img">
          <img src="<?=$bet['lot_image']?>" width="54" height="40" alt="Фото лота">
        </div>
        <h3 class="rates__title"><a href="lot.php?id=<?=$bet['lot']?>.php"><?=htmlspecialchars($bet['lot_title'])?></a></h3>
        <p class="rates__contacts"><?=htmlspecialchars($bet['contacts'])?></p>
      </td>
      <td class="rates__category">
        <?=$bet['lot_category']?>
      </td>
      <td class="rates__timer">
        <div class="timer timer--finishing <?php echo $bet['winner'] === $user['id'] ? 'timer--win' : '';?>"><?=getLotRemainingTime($bet['lot_end_date']);?></div>
      </td>
      <td class="rates__price">
        <?=$bet['price']?>
      </td>
      <td class="rates__time">
        <?=getRelativeTime($bet['created_time'])?>
      </td>
    </tr>
    <?php endforeach;?>
  </table>
</section>