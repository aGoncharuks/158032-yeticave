<?php

  require_once 'init.php';

  session_start();

  // if already logged in - redirect to main page
  if(isset($_SESSION['user'])) {
    goToMainPage();
  }

  $categories = getCategoriesList($link);
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
      if ($user = searchUserByEmail($link, $email)) {
        if (password_verify($password, $user['password_hash'])) {
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
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'categories'));

print($layout_content);


