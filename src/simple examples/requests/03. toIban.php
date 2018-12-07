<?php

use Paybox\Payout\Facade as Paybox;

$payout = new Paybox();

$payout->merchant->id = 123456;
$payout->merchant->secretKey = 'asflerjgsdfv';
$payout->order->amount = 2000;
$payout->order->id = 852014;
$payout->order->description = 'Description';
$payout->customer->id = 131;

$payout->getConfig()->setRecipientBankBic('KZ123456');
$payout->getConfig()->setRecipientIban('12345678910111213141');
$payout->getConfig()->setRecipientIinBin('123456789101');
$payout->getConfig()->setRecipientName('12345678');

if($payout->toIban()) {
    header('Location:' . $payout->redirectUrl);
}
//TODO Call getStatus() if the request returned error code equals 9999