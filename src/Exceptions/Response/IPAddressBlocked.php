<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when ip-address blocked
 */
final class IPAddressBlocked extends Base
{
    /**
     * @var int
     */
    protected $code = 339;
}
