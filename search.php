<?php

require_once 'init.php';

session_start();

$title = 'Результаты поиска';
$categories = getCategoriesList($link);

//if search term is not set => redirect to main page
if(!isset($_GET['search_term'])) {
  goToMainPage();
} else {
  $searchTerm = htmlspecialchars(trim($_GET['search_term']));
}

$itemPerPage = 9;
$pageCount = 0;
$pageOffset = 0;
$currentPage = $_GET['page'] ?? 1;
$addPaginationUrl = "search.php?search_term={$searchTerm}&";

//get search result lots total count
$sqlSearchTerm = "'%{$searchTerm}%'";
$countSql = "
  SELECT 
    COUNT(*) as `count` 
  FROM 
    `lot`
  WHERE
    `lot`.`end_date` >  NOW()
  AND 
    `title` LIKE {$sqlSearchTerm} 
  OR
    `description` LIKE {$sqlSearchTerm};
";

$itemCount = selectData($link, $countSql)[0]['count'];
$pageCount = ceil(intval($itemCount) / $itemPerPage);
$pageOffset = (intval($currentPage) - 1) * $itemPerPage;
$pages = range(1, $pageCount);

//get search result lots
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
    `title` LIKE {$sqlSearchTerm}
  OR
    `description` LIKE {$sqlSearchTerm}
  ORDER BY `lot`.`created_time` DESC
  LIMIT
    ?
  OFFSET 
    ?;
";

$lots = selectData($link, $lotsSql, [$itemPerPage, $pageOffset]);

$pagination = renderTemplate('templates/pagination.php', compact('pages', 'pageCount', 'currentPage', 'addPaginationUrl'));

// main page content code
$page_content = renderTemplate('templates/search.php', compact('pagination', 'categories', 'lots', 'searchTerm'));

// final index page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'categories'));

print($layout_content);