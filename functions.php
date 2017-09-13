<?php

/**
 * Render template with passed data
 * @param $template_path
 * @param $data
 * @return bool|string
 */
function renderTemplate($template_path, $data = array())
{

  try {
    $result = '';

    // Check if template file exists
    if (!is_readable($template_path)) {
      return $result;
    }

    // if any data passed - import variables into the symbol table
    if($data) {
      extract($data);
    }

    // Start buffer
    ob_start('ob_gzhandler');

    //get template content from file
    require_once  $template_path;

    // Get result from buffer and clean buffer
    $result = ob_get_clean();
    return $result;

  } catch (Exception $e) {

    return $e->getMessage();
  }
}

/**
 * Returns 404 status and redirects to 404.php
 */
function goToPageNotFound() {

  // clean output buffer if was opened
  if(ini_get('output_buffering')) {
    ob_clean();
  }

  header("HTTP/1.0 404 Not Found");
  header("Location: 404.php");
}

/**
 * Redirects to main page
 */
function goToMainPage() {

  // clean output buffer if was opened
  if(ini_get('output_buffering')) {
    ob_clean();
  }

  header("Location: index.php");
}

/**
 * Returns 403 status and redirects to login.php
 */
function goToLoginPage() {

  // clean output buffer if was opened
  if(ini_get('output_buffering')) {
    ob_clean();
  }

  header('HTTP/1.0 403 Forbidden');
  header("Location: login.php");
}

/**
 * Get relative lot time
 * @param $ts
 * @return false|string
 */
function getRelativeLotTime($ts) {

  $tsNow = strtotime('now');
  $tsHourAgo = strtotime('-1 hour');
  $tsDayAgo = strtotime('-1 day');

  if($ts < $tsDayAgo) {
    return date('d.m.y H:i', $ts);
  } else if($ts < $tsHourAgo) {
    return gmdate('H', $tsNow - $ts).' часов назад';
  } else {
    return date('i', $tsNow - $ts).' минут назад';
  }
}

/**
 * Checks if passed parameter is numeric
 * @param $value
 * @return mixed
 */
function validateNumber($value) {
  return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
}