<?php

/**
 * Get all ended lots without winner
 * @param $link
 * @return array
 */
function getLotsWithoutWinner($link) {

  $endedLotsSql = "
    SELECT
      *
    FROM
      `lot`
    WHERE
      `end_date` <=  NOW()
    AND
      `winner` IS NULL
  ";

  return selectData($link, $endedLotsSql);
}

/**
 * Get lot last bet
 * @param $link
 * @param $params
 * @return mixed
 */
function getLastBet($link, $params) {

  $lastBetSql = "
    SELECT
      `bet`.*, `user`.`name` as `winner_name`, `user`.`email` as `winner_email`
    FROM
      `bet`
    INNER JOIN 
      `user`
    ON 
      `user`.`id` = `bet`.`author` 
    WHERE
      `lot` = ?
    ORDER BY 
      `price` DESC
    LIMIT 1  
  ";

  return selectData($link, $lastBetSql, $params)[0] ?? false;
}

/**
 * Set lot winner in DB
 * @param $link
 * @param $params
 * @return bool
 */
function setLotWinner($link, $params) {

  $winnerInsertSql = "
    UPDATE 
      `lot`
    SET 
      `winner` = ? 
    WHERE 
      `id` = ? 
  ";

  return executeQuery($link, $winnerInsertSql, $params);
}

/**
 * Get all active lots count
 * @param $link
 * @return mixed
 */
function getAllLotsCount($link) {

  $countSql = "
    SELECT 
      COUNT(*) as `count` 
    FROM 
      `lot`
    WHERE
      `lot`.`end_date` >  NOW()
  ";

  return selectData($link, $countSql)[0]['count'];
}

/**
 * Get all active lots
 * @param $link
 * @param $params
 * @return array
 */
function getAllLots($link, $params) {

  $lotsSql = "
    SELECT `lot`.`id` as `id`, `title`, `created_time`, UNIX_TIMESTAMP(end_date) as `end_date`, `cost`, `image`, `category`.`name` as `category`
    FROM 
      `lot`
    LEFT JOIN 
      `category`
    ON
      `category`.`id` = `lot`.`category`
    WHERE
      `lot`.`end_date` >  NOW()
    ORDER BY `lot`.`created_time` DESC
    LIMIT
      ?
    OFFSET 
      ?
  ";

  return selectData($link, $lotsSql, $params);
}

/**
 * Get category lots total count
 * @param $link
 * @param $params
 * @return mixed
 */
function getCategoryLotsCount($link, $params) {

  $countSql = "
    SELECT 
      COUNT(*) as `count` 
    FROM 
      `lot`
    WHERE
      `lot`.`end_date` >  NOW()
    AND 
      `lot`.`category` = ?
  ";

  return selectData($link, $countSql, $params)[0]['count'];
}

/**
 * Get category lots
 * @param $link
 * @param $params
 * @return array
 */
function getCategoryLots($link, $params) {

  $lotsSql = "
    SELECT `lot`.`id` as `id`, `title`, `created_time`, UNIX_TIMESTAMP(end_date) as `end_date`, `cost`, `image`, `category`.`name` as `category`
    FROM 
      `lot`
    LEFT JOIN 
      `category`
    ON
      `category`.`id` = `lot`.`category`
    WHERE
      `lot`.`end_date` >  NOW()
    AND 
      `lot`.`category` = ?
    ORDER BY `lot`.`created_time` DESC
    LIMIT
      ?
    OFFSET 
      ?
  ";

  return selectData($link, $lotsSql, $params);
}

/**
 * Get detailed data particular lot
 * @param $link
 * @param $params
 * @return bool
 */
function getLot($link, $params) {

  $lotSql = "
    SELECT lot.id, lot.title, lot.cost, lot.image, lot.step, lot.description, UNIX_TIMESTAMP(lot.end_date) as 'end_date', bets.max_bet, bets.bet_count, category.name as `category`, user.contacts as `contacts`
    FROM `lot`
    INNER JOIN
      `user`
    ON 
      `user`.`id` = `lot`.`author`
    LEFT JOIN (
            SELECT
                `lot`, MAX(`price`) as `max_bet`, COUNT(`id`) as `bet_count`
            FROM
                `bet`
            GROUP BY `lot`
            ) as `bets`
        ON
            bets.lot = lot.id
      LEFT JOIN 
        `category`
      ON
        category.id = lot.category
    WHERE
        lot.id = ?
  ";

  return selectData($link, $lotSql, $params)[0] ?? false;
}

/**
 * Get search result lots count
 * @param $link
 * @param $searchTerm
 * @return mixed
 */
function getSearchLotsCount($link, $searchTerm) {

  $searchTerm =  mysqli_real_escape_string($link, $searchTerm);
  $sqlSearchTerm = "'%{$searchTerm}%'";

  $countSql = "
    SELECT 
      COUNT(*) as `count` 
    FROM 
      `lot`
    WHERE
      `lot`.`end_date` >  NOW()
    AND 
      `title` LIKE {$sqlSearchTerm} 
    OR
      `description` LIKE {$sqlSearchTerm};
  ";

  return selectData($link, $countSql)[0]['count'];
}

/**
 * Get search result lots
 * @param $link
 * @param $searchTerm
 * @param $params
 * @return array
 */
function getSearchLots($link, $searchTerm, $params) {

  $searchTerm =  mysqli_real_escape_string($link, $searchTerm);
  $sqlSearchTerm = "'%{$searchTerm}%'";

  $lotsSql = "
    SELECT `lot`.`id` as `id`, `title`, `created_time`, UNIX_TIMESTAMP(end_date) as `end_date`, `cost`, `image`, `category`.`name` as `category`
    FROM 
      `lot`
    LEFT JOIN 
      `category`
    ON
      `category`.`id` = `lot`.`category`
    WHERE
      `lot`.`end_date` >  NOW()
    AND 
      `title` LIKE {$sqlSearchTerm}
    OR
      `description` LIKE {$sqlSearchTerm}
    ORDER BY `lot`.`created_time` DESC
    LIMIT
      ?
    OFFSET 
      ?;
  ";

  return selectData($link, $lotsSql, $params);
}