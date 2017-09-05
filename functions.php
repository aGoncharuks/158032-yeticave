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
 * Shows page 404 and return 404 status in page wasn't found
 */
function showPageNotFound() {
  header("HTTP/1.0 404 Not Found");
  ob_clean();
  require_once('templates/404.php');
}

/**
 * Checks if passed parameter is numeric
 * @param $value
 * @return mixed
 */
function validateNumber($value) {
  return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
}