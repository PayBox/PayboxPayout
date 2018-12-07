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
//[pg_payment_id] => 12345678
//[pg_order_id] => 157674271
//[pg_balance] => 13476085.15
//[pg_payment_amount] => 5000.00
//[pg_to_pay] => 5300
//[pg_merchant_id] => 123456
//[pg_payment_date] => 2018-12-31 15:00:00
//[pg_card_hash] => 123456-XX-XXXX-1234
//[pg_salt] => G66PbiRDxqa44tB8
//[pg_sig] => ae7a022b66c6e866742ab2f99ef8f24f

if ($paybox->checkSig($request)) {
    echo $paybox->accept('Success message');
} else {
    echo 'sig invalid';
}