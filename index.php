<?php

require_once 'init.php';

session_start();
date_default_timezone_set('Europe/Moscow');

$title = 'Аукцион Yeticave';
$categories = getCategoriesList($link);

$itemPerPage = 3;
$pageCount = 0;
$pageOffset = 0;
$currentPage = $_GET['page'] ?? 1;

//get lots total count
$countSql = "
  SELECT 
    COUNT(*) as `count` 
  FROM 
    `lot`
  WHERE
    `lot`.`end_date` >  NOW();
";

$itemCount = selectData($link, $countSql)[0]['count'];
$pageCount = ceil(intval($itemCount) / $itemPerPage);
$pageOffset = (intval($currentPage) - 1) * $itemPerPage;
$pages = range(1, $pageCount);

//get lots
$lotsSql = "
  SELECT `lot`.`id` as `id`, `title`, `created_time`, UNIX_TIMESTAMP(end_date) as `end_date`, `cost`, `image`, `category`.`name` as `category`
  FROM 
    `lot`
  LEFT JOIN 
    `category`
  ON
    `category`.`id` = `lot`.`category`
  WHERE
    `lot`.`end_date` >  NOW()
  ORDER BY `lot`.`created_time` DESC
  LIMIT
    ?
  OFFSET 
    ?;
";

$lots = selectData($link, $lotsSql, [$itemPerPage, $pageOffset]);

$pagination = renderTemplate('templates/pagination.php', compact('pages', 'pageCount', 'currentPage'));

// main page content code
$page_content = renderTemplate('templates/index.php', compact('pagination', 'categories', 'lots'));

// final index page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'categories'));

print($layout_content);