<?php

use Paybox\Payout\Facade as Paybox;

$payout = new Paybox();
$payout->merchant->id = 123456;
$payout->merchant->secretKey = 'asflerjgsdfv';

$result = $payout->getBalance();