<?php

require_once('functions.php');
require_once('lotdata.php');

$page_title = 'Аукцион Yeticave';

$is_auth = (bool) rand(0, 1);
$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

date_default_timezone_set('Europe/Moscow');

$lot_time_remaining = "00:00";
$tomorrow = strtotime('tomorrow midnight');
$now = strtotime('now');
$lot_time_remaining = gmdate( 'H:i', $tomorrow - $now );

//categories array
$categories = [
  'Доски и лыжи',
  'Крепления',
  'Ботинки',
  'Одежда',
  'Инструменты',
  'Разное'
];

// main page content code
$page_content = renderTemplate('templates/main.php', compact('categories', 'lots', 'lot_time_remaining'));

// final index page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'is_auth', 'user_name', 'user_avatar'));

print($layout_content);