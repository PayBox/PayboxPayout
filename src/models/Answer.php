<?php

/*
 * This file is part of the Payout package in (c)Paybox Integration Component.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Paybox\Payout\Models;

use Paybox\Core\Abstractions\Answer as CoreAnswer;

/**
 *
 * @see Paybox\Core\Abstractions\Answer
 *
 * @package Paybox\Payout\Models
 * @version 1.1.0
 * @copyright LLC Paybox.money
 * @license GPLv3 @link https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * @property-write string $status
 *
 * @method setStatus(string $status):bool
 * @method setTimeout(int $timeout):bool
 * @method setDescription(string $description):bool
 *
 */

final class Answer extends CoreAnswer {

    /**
     * @var int $timeout Must be used for set lifetime of payment
     */
    public $timeout;

    /**
     * @var string $description Must be used for set description of order
     */
    public $description;

}
