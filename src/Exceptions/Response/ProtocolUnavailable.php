<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Protocol unavailable exception
 */
final class ProtocolUnavailable extends Base
{
    /**
     * @var int
     */
    protected $code = 152;
}
