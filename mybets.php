<?php

require_once 'init.php';

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
$sql = "
      SELECT bet.id, bet.lot, bet.price, UNIX_TIMESTAMP(bet.created_time) as `created_time`, lot.title as `lot_title`, lot.image as `lot_image`, UNIX_TIMESTAMP(lot.end_date) as `lot_end_date`, lot.winner, category.name as `lot_category`, user.contacts as `contacts`
      FROM 
        bet
      INNER JOIN 
        lot
      ON 
        lot.id = bet.lot
      INNER JOIN
        user
      ON 
        user.id = lot.author
      LEFT JOIN 
        category
      ON 
        category.id = lot.category
      WHERE
        bet.author = ?
      ORDER BY 
        bet.created_time DESC
    ";

$my_bets = selectData($link, $sql, [ $user['id'] ]);

// lot page content code
$page_content = renderTemplate('templates/mybets.php', compact('my_bets', 'lots', 'lot_time_remaining'));

// final page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'categories'));

print($layout_content);
