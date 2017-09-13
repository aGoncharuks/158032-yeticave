<?php

  require_once 'functions.php';
  require_once 'lotdata.php';

  session_start();

  // if not logged in - return 403 status and redirect to login page
  if(!$_SESSION['user']) {
    goToLoginPage();
  }

  $title = 'Добавить лот';
  $required = ['title', 'category', 'cost', 'image', 'description', 'min_bet', 'end_date'];
  $rules = ['cost' => 'validateNumber', 'min_bet' => 'validateNumber'];
  $errors = [];
  $image_mime_types = ['image/png', 'image/jpeg'];
  $info_msg = '';

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

    // lot image file upload
    if (isset($_FILES['image']) && !$_FILES['image']['error']) {
      $file_info = finfo_open(FILEINFO_MIME_TYPE);
      $file_tmp_name = $_FILES['image']['tmp_name'];
      $file_type = finfo_file($file_info, $file_tmp_name);

      // check if file type is image
      if (!in_array($file_type, $image_mime_types)) {
        $errors[] = 'image';
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
    else if(!$_SESSION['image']){
      $errors[] = 'image';
    }

    // if no errors - redirect to lot page
    if (!count($errors)) {

      unset($_SESSION['image']);

      // @todo save new lot data in database here

      $new_lot_index = count($lots) + 1;
      header("Location: lot.php?id=$new_lot_index");
    }
  }

// lot page content code
$page_content = renderTemplate('templates/add.php', compact('errors', 'info_msg'));

// final page code
$layout_content = renderTemplate('templates/layout.php', compact('page_content', 'title'));

print($layout_content);


