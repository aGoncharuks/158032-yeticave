<?php

require_once 'init.php';

session_start();
date_default_timezone_set('Europe/Moscow');

$title = 'Аукцион Yeticave';

$lot_time_remaining = "00:00";
$tomorrow = strtotime('tomorrow midnight');
$now = strtotime('now');
$lot_time_remaining = gmdate( 'H:i', $tomorrow - $now );

$categories = getCategoriesList($link);

//get lots
$sql = "
  SELECT lot.id as `id`, `title`, `cost`, `image`, category.name as `category`
  FROM 
    `lot`
  LEFT JOIN 
    `category`
  ON
    category.id = lot.category
  WHERE
    `end_date` >  NOW()
  LIMIT
    ?;
";
$lots = selectData($link, $sql, ['6']);

// main page content code
$page_content = renderTemplate('templates/index.php', compact('categories', 'lots', 'lot_time_remaining'));

// final index page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'categories'));

print($layout_content);