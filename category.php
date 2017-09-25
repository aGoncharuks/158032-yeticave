<?php

require_once 'init.php';
require_once 'queries/category.php';
require_once 'queries/lot.php';

session_start();

$categories = getCategoriesList($link);

//if category is not set => redirect to main page
if(!isset($_GET['category'])) {
  goToMainPage();
}

$category = $_GET['category'];
$categoryName = getCategoryName($link, [ $category ]);

$title = "Лоты в категории {$categoryName}";

$itemPerPage = 9;
$pageCount = 0;
$pageOffset = 0;
$currentPage = $_GET['page'] ?? 1;
$addPaginationUrl = "category.php?category={$category}&";

//get category lots total count
$itemCount = getCategoryLotsCount($link, [ $category ]);

$pageCount = ceil(intval($itemCount) / $itemPerPage);
$pageOffset = (intval($currentPage) - 1) * $itemPerPage;
$pages = range(1, $pageCount);

//get category lots
$lots = getCategoryLots($link, [ $category, $itemPerPage, $pageOffset ]);

$pagination = renderTemplate('templates/pagination.php', compact('pages', 'pageCount', 'currentPage', 'addPaginationUrl'));

// main page content code
$page_content = renderTemplate('templates/category.php', compact('pagination', 'categories', 'lots', 'categoryName'));

// final index page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'categories'));

print($layout_content);