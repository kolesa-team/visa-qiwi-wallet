<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when wallet blocked
 */
final class WalletBlocked extends Base
{
    /**
     * @var int
     */
    protected $code = 774;
}
