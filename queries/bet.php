<?php

/**
 * Get bets for particular lot
 * @param $link
 * @param $params
 * @return array
 */
function getLotBets($link, $params) {

  $betsSql = "
    SELECT bet.id as `id`, bet.price, user.name as `author`, UNIX_TIMESTAMP(bet.created_time) as `created_time`
    FROM 
      `bet`
    INNER JOIN 
      `user`
    ON user.id = bet.author
    WHERE
      lot = ?
    ORDER BY 
      bet.created_time DESC
  ";

  return selectData($link, $betsSql, $params);
}

function getUsersBets($link, $params) {

  $betsSql = "
      SELECT bet.id, bet.lot, bet.price, UNIX_TIMESTAMP(bet.created_time) as `created_time`, lot.title as `lot_title`, lot.image as `lot_image`, UNIX_TIMESTAMP(lot.end_date) as `lot_end_date`, lot.winner, category.name as `lot_category`, user.contacts as `contacts`
      FROM 
        bet
      INNER JOIN 
        lot
      ON 
        lot.id = bet.lot
      INNER JOIN
        user
      ON 
        user.id = lot.author
      LEFT JOIN 
        category
      ON 
        category.id = lot.category
      WHERE
        bet.author = ?
      ORDER BY 
        bet.created_time DESC
    ";

  return selectData($link, $betsSql, $params);
}