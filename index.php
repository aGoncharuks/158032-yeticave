<?php

require_once 'init.php';
require_once 'getwinner.php';
require_once 'queries/lot.php';

session_start();

$title = 'Аукцион Yeticave';
$categories = getCategoriesList($link);

$itemPerPage = 3;
$pageCount = 0;
$pageOffset = 0;
$currentPage = $_GET['page'] ?? 1;
$addPaginationUrl = '/?';

//get lots total count
$itemCount = getAllLotsCount($link);
$pageCount = ceil(intval($itemCount) / $itemPerPage);
$pageOffset = (intval($currentPage) - 1) * $itemPerPage;
$pages = range(1, $pageCount);

//get lots
$lots = getAllLots($link, [$itemPerPage, $pageOffset]);

$pagination = renderTemplate('templates/pagination.php', compact('pages', 'pageCount', 'currentPage', 'addPaginationUrl'));

// main page content code
$page_content = renderTemplate('templates/index.php', compact('pagination', 'categories', 'lots'));

// final index page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'categories'));

print($layout_content);