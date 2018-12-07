<?php

/*
 * This file is part of the Payout package in (c)Paybox Integration Component.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Paybox\Payout;

use Paybox\Core\Exceptions\Property as PropertyException;
use Paybox\Core\Exceptions\Connection as ConnectionException;
use Paybox\Core\Exceptions\Request as RequestException;
use Paybox\Core\Abstractions\DataContainer;
use Paybox\Core\Interfaces\Payout as PayoutInterface;

/**
 * Facade of Paybox\Payout classes
 * Simple facade for comfortable using a whole Paybox Payout functionality
 *
 * @package Paybox\Payout
 * @version 1.1.0
 * @copyright LLC Paybox.money
 * @license GPLv3 @link https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * @property Paybox\Payout\Models\Answer $answer
 * @property Paybox\Payout\Models\Card $card
 * @property Paybox\Payout\Models\Config $config
 * @property Paybox\Payout\Models\Customer $customer
 * @property Paybox\Payout\Models\Merchant $merchant
 * @property Paybox\Payout\Models\Order $order
 * @property Paybox\Payout\Models\Payment $payment
 *
 */

class Facade extends DataContainer implements PayoutInterface {

    /**
     * @var url $redurectUrl for saving link to payment page
     */
    public $redirectUrl;

    /**
     * @var url $url
     */
    public $url;

    /**
     *
     * Method for payout to registered card
     *
     * Method get all required params, check filling and send request to Paybox
     *
     * @return bool|Exception
     *
     */

    public function reg2reg() {
        try {
            $this->order->required('amount');
            $this->order->required('description');
            $this->customer->required('id');
            $this->card->required('cardIdTo');
            $this->config->required('postLink');
            $this->config->required('orderTimeLimit');
            $this->save('api/reg2reg', false);
            $this->send();
            $this->redirectUrl = $this->getServerAnswer('redirect_url');
            return true;
        } catch(PropertyException $e) {
            echo $e->getMessage();
        } catch(ConnectionException $e) {
            echo $e->getMessage();
        } catch(RequestException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    /**
     *
     * Method for payout to unregistered card
     *
     * @return bool|Exception
     *
     */

    public function reg2nonreg() {
        try {
            $this->order->required('amount');
            $this->order->required('description');
            $this->config->required('backLink');
            $this->config->required('postLink');
            $this->config->required('orderTimeLimit');
            $this->save('api/reg2nonreg', false);
            $this->send();
            $this->redirectUrl = $this->getServerAnswer('redirect_url');
            return true;
        } catch(PropertyException $e) {
            echo $e->getMessage();
        } catch(ConnectionException $e) {
            echo $e->getMessage();
        } catch(RequestException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    /**
     *
     * Method for payout via IBAN
     *
     * @return bool|Exception
     *
     */

    public function toIban() {
        try {
            $this->order->required('amount');
            $this->order->required('description');
            $this->save('/api/iban_payout', false);
            $this->send();
            $this->redirectUrl = $this->getServerAnswer('redirect_url');
            return true;
        } catch(PropertyException $e) {
            echo $e->getMessage();
        } catch(ConnectionException $e) {
            echo $e->getMessage();
        } catch(RequestException $e) {
            echo $e->getMessage();
        }

        return false;
    }

    /**
     * This method send request to paybox, for getting a status of payment or order
     *
     * If You use orderId for getStatus(), possible answers is:
     *   partial | pending | ok | failed | revoked | incomplete
     *
     * If You use getStatus() with paymentId, You can get one of statuses:
     *   new | ok | revoked | failed | incomplete
     *
     * @return string|bool|Exception
     *
     */

    public function getIbanStatus() {
        try {
            $this->order->required('id');
            $this->save('api/iban_payout/payment_status', false);
            $this->send();
            return $this->getServerAnswer('status');
        } catch(PropertyException $e) {
            echo $e->getMessage();
        } catch(ConnectionException $e) {
            echo $e->getMessage();
        } catch(RequestException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * This method send request to paybox, for getting a status of payment or order
     *
     * If You use orderId for getStatus(), possible answers is:
     *   partial | pending | ok | failed | revoked | incomplete
     *
     * If You use getStatus() with paymentId, You can get one of statuses:
     *   new | ok | revoked | failed | incomplete
     *
     * @return string|bool|Exception
     *
     */

    public function getStatus() {
        try {
            $this->order->required('id');
            $this->save('api/payment_status', false);
            $this->send();
            return $this->getServerAnswer('status');
        } catch(PropertyException $e) {
            echo $e->getMessage();
        } catch(ConnectionException $e) {
            echo $e->getMessage();
        } catch(RequestException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * This method send request to paybox, for getting a status of balance
     *
     * @return string|bool|Exception
     *
     */

    public function getBalance() {
        try {
            $this->save('api/balance_status', false);
            $this->send();
            return $this->getServerAnswer('status');
        } catch(PropertyException $e) {
            echo $e->getMessage();
        } catch(ConnectionException $e) {
            echo $e->getMessage();
        } catch(RequestException $e) {
            echo $e->getMessage();
        }
    }

    /**
     *
     * Use it for answer on Your postLink (@see Payout\Models\Config::$postLink)
     *
     * @param string $successMessage
     *
     * @return XML formatted answer for Paybox
     *
     */

    public function accept($successMessage) {
        header('Content-Type: application/xml', true, 200);
        $this->answer->status = 'ok';
        $this->answer->description = $successMessage;
        $this->save();
        return $this->answer();
    }

    /**
     *
     * Parse a request from Paybox and return it as array
     *
     * @param XML $request
     *
     * @return array
     */

    public function parseXML($request) {
        return (array) (new \SimpleXMLElement($request['pg_xml']));
    }

    /**
     *
     * Get a url of Payment gate
     *
     * @return string
     *
     */

    protected function getBaseUrl() {
        return 'https://api.paybox.money/';
    }

    /**
     * This method convert Your answers to XML
     *
     * @return XML
     *
     */

    private function answer() {
        $this->toXML();
        return $this->xml->asXML();
    }
}