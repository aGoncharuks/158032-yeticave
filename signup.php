<?php

  require_once 'init.php';

  session_start();

  $categories = getCategoriesList($link);
  $title = 'Регистрация';
  $required = ['email', 'password', 'name', 'contacts'];
  $rules = ['email' => 'validateEmail', 'password' => 'checkPasswordLength'];
  $errors = [
    'required' => [],
    'custom' => []
  ];
  $image_mime_types = ['image/png', 'image/jpeg'];
  $info_msg = '';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    foreach ($_POST['form'] as $key => $value) {

      // required fields validation
      if (!$_POST['form'][$key] || in_array($key, $required) && $value == '') {
        $errors['required'][] = $key;
      }

      // other custom validation
      if ($rules[$key]) {
        $result = call_user_func($rules[$key], $value);
        if (!$result) {
          $errors['custom'][] = $key;
        }
      }
    }

    // user avatar image file upload
    if (isset($_FILES['image']) && !$_FILES['image']['error']) {
      $file_info = finfo_open(FILEINFO_MIME_TYPE);
      $file_tmp_name = $_FILES['image']['tmp_name'];
      $file_type = finfo_file($file_info, $file_tmp_name);

      // check if file type is image
      if (!in_array($file_type, $image_mime_types)) {
        $errors['custom'][] = 'image';
      } else {
        $file_name = $_FILES['image']['name'];
        $file_path = __DIR__ . '/img/' . $file_name;

        // in image save failed for any reason on server side(directory name changed etc.) => show info message to user
        if (!move_uploaded_file($file_tmp_name, $file_path)) {
          $info_msg = 'Ошибка при сохранении картинки, пожалуйста свяжитесь с нашим техническим отделом';
        };

        // save image in session to avoid loosing image if form don't pass validation in first attempt
        $_SESSION['image'] = $_FILES['image'];
      }
    }
    if(!count($errors['required']) && !count($errors['custom'])) {

      //check user with this this email already exists
      if (searchUserByEmail($link, $_POST['form']['email'])) {
        $errors['custom'][] = 'email_used';
      }
      // if no errors - save user in DB and redirect to login page
      else {
        $newUser = $_POST['form'];

        //if new image was uploaded on last submit - take it, else take previously saved in session one
        $imageFileName = (isset($_FILES['image']) && !$_FILES['image']['error']) ?  $_FILES['image']['name'] : $_SESSION['image']['name'];
        $newUser['avatar'] = "img/{$imageFileName}";
        unset($_SESSION['image']);

        //create password hash and remove password key from array
        $newUser['password_hash'] = password_hash($newUser['password'], PASSWORD_DEFAULT);
        unset($newUser['password']);

        $result = insertData($link, 'user', $newUser);
        if($result) {
          header("Location: login.php?from_signup=1");
        } else {
          $info_msg = 'Ошибка при сохранении пользователяы, пожалуйста свяжитесь с нашим техническим отделом';
        }
      }

    }
  }

// lot page content code
$page_content = renderTemplate('templates/signup.php', compact('errors', 'info_msg', 'categories'));

// final page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title', 'categories'));

print($layout_content);

