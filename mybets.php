<?php

require_once 'init.php';
require_once 'queries/bet.php';

session_start();

// if not logged in - redirect to login page
if(!$_SESSION['user']) {
  goToLoginPage();
} else {
  $user = $_SESSION['user'];
}

$categories = getCategoriesList($link);
$title = 'Мои ставки';

// get user's bets
$my_bets = getUsersBets($link, [ $user['id'] ]);

// lot page content code
$page_content = renderTemplate('templates/mybets.php', compact('my_bets', 'lots', 'lot_time_remaining'));

// final page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'categories'));

print($layout_content);
