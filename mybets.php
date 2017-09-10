<?php

require_once 'functions.php';
require_once 'lotdata.php';

session_start();

// if not logged in - redirect to login page
if(!$_SESSION['user']) {
  goToLoginPage();
}

$title = 'Мои ставки';
$my_bets = [];

$lot_time_remaining = "00:00";
$tomorrow = strtotime('tomorrow midnight');
$now = strtotime('now');
$lot_time_remaining = gmdate( 'H:i', $tomorrow - $now );


// get user's bets
if($_SESSION['my_bets']) {
  $my_bets = json_decode($_SESSION['my_bets'], true);
}

// lot page content code
$page_content = renderTemplate('templates/mybets.php', compact('my_bets', 'lots', 'lot_time_remaining'));

// final page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title'));

print($layout_content);
