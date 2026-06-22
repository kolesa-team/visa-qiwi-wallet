<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when requested currency is not permitted
 */
final class CurrencyNotPermitted extends Base
{
    /**
     * @var int
     */
    protected $code = 1001;
}
