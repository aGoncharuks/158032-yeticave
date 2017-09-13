<?php

  require_once 'functions.php';
  require_once 'lotdata.php';

  //check if there is no existing bet for this lot
  function checkIfAlreadyBet($bets) {
    $result = false;
    foreach ($bets as $bet) {
      if ($bet['lot_id'] === $_GET['id']) {
        $result = true;
        break;
      }
    }
    return $result;
  }

  session_start();
  date_default_timezone_set('Europe/Moscow');
  ob_start();

  $bets = [
      ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-20 minute')],
      ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-5 hour')],
      ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-2 day')],
      ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('-1 week')]
  ];

  $my_bets = [];
  $already_bet = false;

  // get user's bets and check if user already made bet for this lot
  if($_SESSION['my_bets']) {
    $my_bets = json_decode($_SESSION['my_bets'], true);
    $already_bet = checkIfAlreadyBet($my_bets);
  }

  $required = ['cost'];
  $rules = ['cost' => 'validateNumber'];

  $errors = [];

  // get lot data and return page content if lot found, else return empty page with 404 status
  if( isset($_GET['id']) && $lots[$_GET['id']]) {

    $lot = $lots[$_GET['id']];

  // set page title
    $title = $lot['title'];

  //handle bet adding form submit
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['form'] as $key => $value) {

      // required fields validation
      if (!$_POST['form'][$key] || in_array($key, $required) && $value == '') {
        $errors[] = $key;
      }

      // other custom validation
      if ($rules[$key]) {
        $result = call_user_func($rules[$key], $value);
        if (!$result) {
          $errors[] = $key;
        }
      }

      // if no errors - save bet in session variable and redirect to 'my bets' page
      if (!count($errors)) {

        $new_bet = [
          'cost' => $_POST['form']['cost'],
          'ts' => strtotime('now'),
          'lot_id' => $_GET['id']
        ];

        array_push($my_bets, $new_bet);
        $_SESSION['my_bets'] = json_encode($my_bets);
        header("Location: mybets.php");
        ob_flush();
      }
    }
  }

  // lot page content code
    $page_content = renderTemplate('templates/lot.php', compact('lot', 'bets', 'errors', 'already_bet'));

  // final page code
    $layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title'));

    print($layout_content);

    ob_flush();

  } else {
    goToPageNotFound();
  }