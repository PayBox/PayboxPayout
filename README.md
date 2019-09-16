# API для выплат PayBox.Money
___
Пакет упрощает интеграцию взаимодействия с выплатами платежей Paybox.

## 1) Установка пакета

Для установки пакета пропишите команду в консольке:

```sh
$ composer require payboxmoney/payout "^1.2"
```


## 2) Запросы
  - [Выплата с зарегистрированный карты на незарегистрированную](#Выплата-с-зарегистрированный-карты-на-незарегистрированную)
  - [Перевод с зарегистрированной карты на зарегистрированную](#Перевод-с-зарегистрированной-карты-на-зарегистрированную)
  - [Запрос на получение статуса транзакции](#Запрос-на-получение-статуса-транзакции)

### Выплата с зарегистрированный карты на незарегистрированную

[Подробное описание](https://paybox.money/docs/ru/pay-out/3.0#tag/Bazovye-zaprosy/paths/~1api~1reg2nonreg/post)

#### Пример
~~~php
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
~~~
---
### Перевод с зарегистрированной карты на зарегистрированную

[Подробное описание](https://paybox.money/docs/ru/pay-out/3.0#tag/Bazovye-zaprosy/paths/~1api~1reg2reg/post)

#### Пример
~~~php
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
~~~
---

### Запрос на получение статуса транзакции

[Подробное описание](https://paybox.money/docs/ru/pay-out/3.0#tag/Dopolnitelnye-zaprosy/paths/~1api~1payment_status/post)

#### Пример
~~~php
<?php
use Paybox\Payout\Facade as Paybox;
$payout = new Paybox();
$payout->merchant->id = 123456;
$payout->merchant->secretKey = 'asflerjgsdfv';
$payout->order->id = 852014;
$result = $payout->getStatus();
~~~
---
