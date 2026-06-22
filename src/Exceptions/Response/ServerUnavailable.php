<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when server is unavailable
 */
final class ServerUnavailable extends Base
{
    /**
     * @var int
     */
    protected $code = 13;
}
