<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when exchange rates for requested currency is not available
 */
final class CurrencyRateUnavailable extends Base
{
    /**
     * @var int
     */
    protected $code = 1003;
}
