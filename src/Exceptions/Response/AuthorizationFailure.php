<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Authorization exception
 */
final class AuthorizationFailure extends Base
{
    /**
     * @var int
     */
    protected $code = 150;
}
