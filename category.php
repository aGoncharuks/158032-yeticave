<?php

require_once 'init.php';

session_start();

$categories = getCategoriesList($link);

//if category is not set => redirect to main page
if(!isset($_GET['category'])) {
  goToMainPage();
}

$category = $_GET['category'];

$categorySql = "
  SELECT 
    `name`
  FROM 
    `category`
  WHERE
    `id` = ?
";

$categoryName = selectData($link, $categorySql, [ $category ])[0]['name'];

$title = "Лоты в категории {$categoryName}";

$itemPerPage = 9;
$pageCount = 0;
$pageOffset = 0;
$currentPage = $_GET['page'] ?? 1;
$addPaginationUrl = "category.php?category={$category}&";

//get category lots total count
$countSql = "
  SELECT 
    COUNT(*) as `count` 
  FROM 
    `lot`
  WHERE
    `lot`.`end_date` >  NOW()
  AND 
    `lot`.`category` = ?
";

$itemCount = selectData($link, $countSql, [ $category ])[0]['count'];
$pageCount = ceil(intval($itemCount) / $itemPerPage);
$pageOffset = (intval($currentPage) - 1) * $itemPerPage;
$pages = range(1, $pageCount);

//get category lots
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
  AND 
    `lot`.`category` = ?
  ORDER BY `lot`.`created_time` DESC
  LIMIT
    ?
  OFFSET 
    ?;
";

$lots = selectData($link, $lotsSql, [$category, $itemPerPage, $pageOffset]);

$pagination = renderTemplate('templates/pagination.php', compact('pages', 'pageCount', 'currentPage', 'addPaginationUrl'));

// main page content code
$page_content = renderTemplate('templates/category.php', compact('pagination', 'categories', 'lots', 'categoryName'));

// final index page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'categories'));

print($layout_content);