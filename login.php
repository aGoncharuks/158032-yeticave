<?php

  require_once 'functions.php';
  require_once 'userdata.php';

  session_start();

  function searchUserByEmail($email, $users)
  {
    $result = null;
    foreach ($users as $user) {
      if ($user['email'] === $email) {
        $result = $user;
        break;
      }
    }
    return $result;
  }


  // if already logged in - redirect to main page
  if($_SESSION['user']) {
    goToMainPage();
  }

  $title = 'Логин';

  $required = ['email', 'password'];
  $errors = [
    'required' => [],
    'custom' => []
  ];

  //handle login form submit
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['form'] as $key => $value) {
      // required fields validation
      if (!$_POST['form'][$key] || in_array($key, $required) && $value == '') {
        $errors['required'][] = $key;
      }
    }
    // if form has no errors - check if user exists
    if (!count($errors['required'])) {
      $email = $_POST['form']['email'];
      $password = $_POST['form']['password'];
      if ($user = searchUserByEmail($email, $users)) {
        if (password_verify($password, $user['password'])) {
          $_SESSION['user'] = $user;
          goToMainPage();
        } else {
          $errors['custom'][] = 'password';
        }
      } else {
        $errors['custom'][] = 'email';
      }
    }
  }

// lot page content code
$page_content = renderTemplate('templates/login.php', compact('errors'));

// final page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title'));

print($layout_content);


