<?php

  require_once 'init.php';
  require_once 'queries/lot.php';
  require_once 'queries/bet.php';

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

  //return max bet price or(if no bets) - lot initial cost
  function getLotMaxPrice($lot, $bets) {

    $result = intval($lot['cost']);
    foreach ($bets as $bet) {
      if (intval($bet['price']) > intval($result)) {
        $result = intval($bet['price']);
      }
    }
    return $result;
  }

  session_start();
  ob_start();

  $categories = getCategoriesList($link);
  $bets = [];
  $my_bets = [];
  $already_bet = false;
  $title = '';

  // get user's bets and check if user already made bet for this lot
  if( isset($_SESSION['my_bets']) ) {
    $my_bets = json_decode($_SESSION['my_bets'], true);
    $already_bet = checkIfAlreadyBet($my_bets);
  }

  $required = ['price'];
  $rules = ['price' => 'validatePositiveNumber'];

  $errors = [];

  if( isset($_GET['id']) ) {

    //get lot
    $lot = getLot($link, [ $_GET['id'] ]);
  } else {
    goToPageNotFound();
  }


  // get lot data and return page content if lot found, else return empty page with 404 status
  if( $lot ) {

    //get lot bets
    $bets = getLotBets($link, [ $_GET['id'] ]);

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
      }

      //check if new price is bigger than old one + minimal step
      $currentPrice = intval($lot['max_bet']) > intval($lot['cost']) ? intval($lot['max_bet']) : intval($lot['cost']);
      if(intval($_POST['form']['price']) < $currentPrice + intval($lot['step'])) {
        $errors[] = 'price';
      }

      // if no errors - save bet in session variable and redirect to 'my bets' page
      if (!count($errors)) {

        $newBet = [
          'price' => $_POST['form']['price'],
          'lot' => $lot['id'],
          'author' => $_SESSION['user']['id']
        ];

        if(insertData($link, 'bet', $newBet)) {
          header("Location: mybets.php");
        };

        ob_flush();
      }
    }

    // lot page content code
    $page_content = renderTemplate('templates/lot.php', compact('lot', 'bets', 'errors', 'already_bet'));

    // final page code
    $layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'categories'));

    print($layout_content);

    ob_flush();

  } else {
    goToPageNotFound();
  }