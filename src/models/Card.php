<?php

/*
 * This file is part of the Payout package in (c)Paybox Integration Component.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Paybox\Payout\Models;

use Paybox\Core\Abstractions\Card as CoreCard;

/**
 * @see Paybox\Core\Abstractions\Card
 *
 * @package Paybox\Payout\Models
 * @version 1.1.0
 * @copyright LLC Paybox.money
 * @license GPLv3 @link https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * @property-write string $id
 * @method setId(string $id):bool
 *
 */

final class Card extends CoreCard {

    public $cardIdTo;

}
