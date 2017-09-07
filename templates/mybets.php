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
<section class="rates container">
  <h2>Мои ставки</h2>
  <table class="rates__list">
    <?php foreach ($my_bets as $bet):?>
    <tr class="rates__item">
      <td class="rates__info">
        <div class="rates__img">
          <img src="../img/rate<?=intval($bet['lot_id']) + 1?>.jpg" width="54" height="40" alt="Сноуборд">
        </div>
        <h3 class="rates__title"><a href="lot/<?=$bet['lot_id']?>.php"><?=htmlspecialchars($lots[$bet['lot_id']]['title'])?></a></h3>
      </td>
      <td class="rates__category">
        <?=$lots[$bet['lot_id']]['category']?>
      </td>
      <td class="rates__timer">
        <div class="timer timer--finishing"><?=$lot_time_remaining;?></div>
      </td>
      <td class="rates__price">
        <?=$bet['cost']?>
      </td>
      <td class="rates__time">
        <?=getRelativeLotTime($bet['ts'])?>
      </td>
    </tr>
    <?php endforeach;?>
  </table>
</section>