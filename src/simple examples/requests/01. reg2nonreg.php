<?php

use Paybox\Payout\Facade as Paybox;

$payout = new Paybox();

$payout->merchant->id = 123456;
$payout->merchant->secretKey = 'asflerjgsdfv';
$payout->order->description = 'Description';
$payout->order->amount = 100;
$payout->order->id = 902003;

$payout->getConfig()->setPostLink('http://site.kz/');
$payout->getConfig()->setBackLink('http://site.kz/');
$payout->getConfig()->setOrderTimeLimit('2019-11-25 00:00:00');

if($payout->reg2nonreg()) {
    header('Location:' . $payout->redirectUrl);
}

//TODO Call getStatus() if the request returned error code equals 9999