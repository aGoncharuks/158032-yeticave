<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?= htmlspecialchars($lastBet['winner_name']) ?></p>
<p>Ваша ставка для лота <a href="<?= "{$_SERVER['HTTP_HOST']}/lot.php?id={$lot['id']}" ?>"><?= htmlspecialchars($lot['title']) ?></a> победила.</p>
<p>Перейдите по ссылке <a href="<?= "{$_SERVER['HTTP_HOST']}/mybets.php" ?>">мои ставки</a>,
  чтобы связаться с автором объявления</p>

<small>Интернет Аукцион "YetiCave"</small>