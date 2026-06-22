<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when requested bill is being paid
 */
final class BillInProgress extends Base
{
    /**
     * @var int
     */
    protected $code = 1419;
}
