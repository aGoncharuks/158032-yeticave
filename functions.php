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
 * Checks if passed parameter is numeric
 * @param $value
 * @return mixed
 */
function validateNumber($value) {

  return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
}


/**
 * Select data from DB
 * @param $link
 * @param $sql
 * @param $data
 * @return array
 */
function selectData($link, $sql, $data) {

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
    $keys = [];
    $values = [];

    foreach ($data as $key => $value){
      $keys[] = $key;
      $values[] = $value;
    }

    $columnNameString = join(', ', $keys);
    $valuePlaceholderString = '';

    $last_key = end(array_keys($keys));
    foreach ($values as $key => $value) {
      if ($key !== $last_key) {
        $valuePlaceholderString.= '?, ';
      } else {
        $valuePlaceholderString.= '?';
      }
    }
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
function executeQuery($link, $sql, $data) {

  try {
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $result = mysqli_stmt_execute($stmt);

    return $result;
  } catch (Exception $e) {
    return false;
  }
}
