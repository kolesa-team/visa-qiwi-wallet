<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when monthly limit exceeded
 */
final class MonthlyLimitExceeded extends Base
{
    /**
     * @var int
     */
    protected $code = 700;
}
