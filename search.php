<?php

require_once 'init.php';
require_once 'queries/lot.php';

session_start();

$title = 'Результаты поиска';
$categories = getCategoriesList($link);
$searchTerm = '';

//if search term is not set => redirect to main page
if(!isset($_GET['search_term'])) {
  goToMainPage();
} else {
  $searchTerm = trim($_GET['search_term']);
}

$itemPerPage = 9;
$pageCount = 0;
$pageOffset = 0;
$currentPage = $_GET['page'] ?? 1;
$addPaginationUrl = "search.php?search_term={$searchTerm}&";

//get search result lots total count
$itemCount = getSearchLotsCount($link, $searchTerm);
$pageCount = ceil(intval($itemCount) / $itemPerPage);
$pageOffset = (intval($currentPage) - 1) * $itemPerPage;
$pages = range(1, $pageCount);

//get search result lots
$lots = getSearchLots($link, $searchTerm, [$itemPerPage, $pageOffset]);

$pagination = renderTemplate('templates/pagination.php', compact('pages', 'pageCount', 'currentPage', 'addPaginationUrl'));

// main page content code
$page_content = renderTemplate('templates/search.php', compact('pagination', 'categories', 'lots', 'searchTerm'));

// final index page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'categories'));

print($layout_content);