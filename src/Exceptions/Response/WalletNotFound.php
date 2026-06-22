<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Wallet not found exception
 */
final class WalletNotFound extends Base
{
    /**
     * @var int
     */
    protected $code = 298;
}
