<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Invalid operation exception
 */
final class InvalidOperation extends Base
{
    /**
     * @var int
     */
    protected $code = 78;
}
