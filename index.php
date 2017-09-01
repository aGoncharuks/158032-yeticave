<?php

require_once('functions.php');

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

//lots array
$lots = [
  [
    'title' => '2014 Rossignol District Snowboard',
    'category' => 'Доски и лыжи',
    'cost' => '10999',
    'image' => 'img/lot-1.jpg'
  ],
  [
    'title' => 'DC Ply Mens 2016/2017 Snowboard',
    'category' => 'Доски и лыжи	',
    'cost' => '159999',
    'image' => 'img/lot-2.jpg'
  ],
  [
    'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
    'category' => 'Крепления',
    'cost' => '8000',
    'image' => 'img/lot-3.jpg'
  ],
  [
    'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
    'category' => 'Ботинки',
    'cost' => '10999',
    'image' => 'img/lot-4.jpg'
  ],
  [
    'title' => 'Куртка для сноуборда DC Mutiny Charocal',
    'category' => 'Одежда',
    'cost' => '7500',
    'image' => 'img/lot-5.jpg'
  ],
  [
    'title' => 'Маска Oakley Canopy',
    'category' => 'Разное',
    'cost' => '5400',
    'image' => 'img/lot-6.jpg'
  ]
];

//// main page content code
$page_content = renderTemplate('templates/main.php', [
  'categories' => $categories,
  'lots' => $lots
]);


// final index page code
$layout_content = renderTemplate('templates/layout.php', [
  'content' => $page_content,
  'title' => $page_title,
  'is_auth' => $is_auth,
  'user_name' => $user_name,
  'user_avatar' => $user_avatar
]);


print($layout_content);