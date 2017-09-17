<?php
require_once 'functions.php';

$link = mysqli_connect("localhost", "root", "", "yeticave");
if (!$link) {
  $error = mysqli_connect_error();
  $content = renderTemplate('templates/error.php', ['error' => $error]);
  print ($content);
  exit();
}