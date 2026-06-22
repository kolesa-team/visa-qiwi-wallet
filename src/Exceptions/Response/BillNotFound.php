<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Bill not found exception
 */
final class BillNotFound extends Base
{
    /**
     * @var int
     */
    protected $code = 210;
}
