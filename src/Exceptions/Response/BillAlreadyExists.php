<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when bill already exists
 */
final class BillAlreadyExists extends Base
{
    /**
     * @var int
     */
    protected $code = 215;
}
