<?php

  require_once 'functions.php';

  session_start();

  // remove user from session and redirect to main page
  unset($_SESSION['user']);
  goToMainPage();

