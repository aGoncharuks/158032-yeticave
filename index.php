<?php

require_once 'functions.php';
require_once 'lotdata.php';

session_start();
date_default_timezone_set('Europe/Moscow');

$title = 'Аукцион Yeticave';

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
$page_content = renderTemplate('templates/index.php', compact('categories', 'lots', 'lot_time_remaining'));

// final index page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title'));

print($layout_content);