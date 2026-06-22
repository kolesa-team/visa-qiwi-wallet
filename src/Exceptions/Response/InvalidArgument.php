<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Invalid argument exception
 */
final class InvalidArgument extends Base
{
    /**
     * @var int
     */
    protected $code = 5;
}
