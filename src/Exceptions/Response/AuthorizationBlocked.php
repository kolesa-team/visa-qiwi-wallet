<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when authorization attempt blocked
 */
final class AuthorizationBlocked extends Base
{
    /**
     * @var int
     */
    protected $code = 316;
}
