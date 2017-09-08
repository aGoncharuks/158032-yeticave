<?php

require_once('functions.php');
require_once('lotdata.php');

$is_auth = (bool) rand(0, 1);
$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

// set default timezone
date_default_timezone_set('Europe/Moscow');

// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-20 minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-5 hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-2 day')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('-1 week')]
];

// get relative lot time
function getRelativeLotTime($ts) {

    $tsNow = strtotime('now');
    $tsHourAgo = strtotime('-1 hour');
    $tsDayAgo = strtotime('-1 day');

    if($ts < $tsDayAgo) {
        return date('d.m.y H:i', $ts);
    } else if($ts < $tsHourAgo) {
      return gmdate('H', $tsNow - $ts).' часов назад';
    } else {
      return date('i', $tsNow - $ts).' минут назад';
    }
}

// get lot data and return page content if lot found, else return empty page with 404 status
if( isset($_GET['id']) && $lots[$_GET['id']]) {

  $lot = $lots[$_GET['id']];

// set page title
  $title = $lot['title'];

// lot page content code
  $page_content = renderTemplate('templates/lot.php', compact('lot', 'bets'));

// final index page code
  $layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'is_auth', 'user_name', 'user_avatar'));

  print($layout_content);

} else {
  showPageNotFound();
}