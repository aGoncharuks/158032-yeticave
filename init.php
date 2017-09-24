<?php

require_once 'vendor/autoload.php';
require_once 'functions.php';

date_default_timezone_set('Europe/Moscow');

$link = mysqli_connect("localhost", "root", "", "yeticave");
if (!$link) {
  $error = mysqli_connect_error();
  $content = renderTemplate('templates/error.php', ['error' => $error]);
  print ($content);
  exit();
}