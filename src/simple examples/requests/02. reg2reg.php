<?php

use Paybox\Payout\Facade as Paybox;

$payout = new Paybox();

$payout->merchant->id = 123456;
$payout->merchant->secretKey = 'asflerjgsdfv';
$payout->order->description = 'Description';
$payout->order->amount = 100;
$payout->order->id = 852014;
$payout->customer->id = 131;
$payout->card->cardIdTo = 1;

$payout->getConfig()->setPostLink('http://site.ru/');
$payout->getConfig()->setBackLink('http://site.ru/');
$payout->getConfig()->setOrderTimeLimit('2019-11-25 00:00:00');

$payout->reg2reg();

//TODO Call getStatus() if the request returned error code equals 9999, 0