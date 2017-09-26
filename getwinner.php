<?php

require_once 'init.php';
require_once 'queries/lot.php';

//get all ended lots with no winner defined yet
$lotsWithoutWinner = getLotsWithoutWinner($link);

//get winner for each ended lot that has bets, save winner id in DB and send information email to him
foreach ($lotsWithoutWinner as $lot) {

  $result = getLastBet($link, [ $lot['id'] ]);

  if($result) {
    $lastBet = $result;

    $result = setLotWinner($link, [ $lastBet['author'], $lot['id'] ]);

    // if winner successfully saved => send information email on winner's e-mail
    if ($result) {
      $mailBody = renderTemplate('templates/email.php', compact('lot', 'lastBet'));

      $transport = new Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl');
      $transport->setUsername('doingsdone@mail.ru');
      $transport->setPassword('rds7BgcL');

      $message = new Swift_Message();
      $message->setTo([$lastBet['winner_email'] => $lastBet['winner_name']]);
      $message->setSubject("Ваш ставка для лота {$lot['title']} победила");
      $message->setBody($mailBody);
      $message->setFrom("doingsdone@mail.ru", "Yeticave");
      $message->setContentType("text/html");

      $mailer = new Swift_Mailer($transport);
      $mailer->send($message);
    }
  }
}
