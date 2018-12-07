<?php

use Paybox\Payout\Facade as Paybox;

$paybox = new Paybox();

$paybox->merchant->id = 123456;
$paybox->merchant->secretKey = 'asflerjgsdfv';

$request = (array_key_exists('pg_xml', $_REQUEST))
    ? $paybox->parseXML($_REQUEST)
    : $_REQUEST;

//example of $request
//[pg_status] => ok
//[pg_merchant_id] => 123456
//[pg_payment_id] => 98728768
//[pg_order_id] => 255704
//[pg_balance] => 14284689
//[pg_payment_date] => 2018-12-31 15:00:00
//[pg_payment_amount] => 100000
//[pg_card_id] => 1234567
//[pg_card_hash] => 1234-44XX-XXXX-1234
//[pg_salt] => JjlVYPtVj7GdjFFi
//[pg_sig] => d2743bad3aa481c59757fc0dbc2f18f1

if ($paybox->checkSig($request)) {
    echo $paybox->accept('Success message');
} else {
    echo 'sig invalid';
}