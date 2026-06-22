<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when operation not permitted
 */
final class OperationNotPermitted extends Base
{
    /**
     * @var int
     */
    protected $code = 319;
}
