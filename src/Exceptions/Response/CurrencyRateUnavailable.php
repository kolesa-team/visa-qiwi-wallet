<?php
/**
 * Created by PhpStorm.
 * User: majesty
 * Date: 01.03.17
 * Time: 15:12
 */

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when exchange rates for requested currency is not available
 */
class CurrencyRateUnavailable extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 1003;
}
