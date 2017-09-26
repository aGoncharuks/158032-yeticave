<?php

/**
 * Get category name
 * @param $link
 * @param $params
 * @return mixed
 */
function getCategoryName($link, $params) {

  $categorySql = "
    SELECT 
      `name`
    FROM 
      `category`
    WHERE
      `id` = ?
  ";

  return selectData($link, $categorySql, $params)[0]['name'];
}