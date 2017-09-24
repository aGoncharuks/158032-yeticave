<?php

require_once 'init.php';
require_once 'mysql_helper.php';

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
 * Returns time remaining to lot closing
 * @param $endTime
 * @return string
 */
function getLotRemainingTime($endTime) {

  $now = strtotime('now');
  return getTimeDifference($now, $endTime);
}

/**
 * Get time difference between two timestamps in readable time difference format
 * @param $timestamp1
 * @param $timestamp2
 * @return string
 */
function getTimeDifference($timestamp1, $timestamp2) {
  $datetime1 = new DateTime('@'.$timestamp1);
  $datetime2 = new DateTime('@'.$timestamp2);

  $interval = date_diff($datetime1, $datetime2);

  return $interval->format('%d дней, %h часов, %i минут');
}


/**
 * Checks if passed parameter is numeric
 * @param $value
 * @return mixed
 */
function validatePositiveNumber($value) {

  return filter_var($value, FILTER_SANITIZE_NUMBER_INT) && $value > 0;
}

/**
 * Checks if passed parameter is email
 * @param $value
 * @return mixed
 */
function validateEmail($value) {

  return filter_var($value, FILTER_VALIDATE_EMAIL);
}

/**
 * Select data from DB
 * @param $link
 * @param $sql
 * @param $data
 * @return array
 */
function selectData($link, $sql, $data  = []) {

  try {
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $resultArr = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if(!$resultArr) {
      return [];
    }

    return $resultArr;
  } catch (Exception $e) {
    return [];
  }
}

/**
 * Insert data in table and get inserted row id
 * @param $link
 * @param $table
 * @param $data
 * @return bool|int
 */
function insertData($link, $table, $data) {

  try {
    $keys = array_keys($data);
    $values = array_values($data);

    $columnNameString = join(', ', $keys);
    $valuePlaceholderString = '';

    foreach ($values as $value) {
      $valuePlaceholderString.= '?, ';
    }

    $valuePlaceholderString = rtrim($valuePlaceholderString, ', ');

    $sql = 'INSERT INTO ' . $table. ' ( ' . $columnNameString . ' ) VALUES ( '. $valuePlaceholderString . ' );';

    $stmt = db_get_prepare_stmt($link, $sql, $values);
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
      return false;
    }

    $lastId = intval(mysqli_insert_id($link));

    return $lastId;
  } catch (Exception $e) {
    return false;
  }
}

/**
 * Execute arbitrary sql statement, return true on success and false on fail
 * @param $link
 * @param $sql
 * @param $data
 * @return bool
 */
function executeQuery($link, $sql, $data = []) {

  try {
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $result = mysqli_stmt_execute($stmt);

    return $result;
  } catch (Exception $e) {
    return false;
  }
}


/**
 * Get categories list, that should be loaded for displaying in header and footer on every page
 * @param $link
 * @return array
 */
function getCategoriesList($link) {

  $sql = "
    SELECT 
      *
    FROM `category`;
  ";

  $categories = selectData($link, $sql);
  return $categories;
}

/**
 * Search user in DB by email, return null if not found
 * @param $link
 * @param $email
 * @return array|null
 */
function searchUserByEmail($link, $email)
{
  $result = null;
  $sql = "
      SELECT *
      FROM 
        `user` 
      WHERE
        `email` = ?;
    ";
  $result = selectData($link, $sql, [ $email ]);

  if(count($result)) {
    $result = $result[0];
  }

  return $result;
}

/**
 * Check if password length is at least 6 symbols
 * @param $password
 * @return bool
 */
function checkPasswordLength($password) {
  return strlen($password) >= 6;
}