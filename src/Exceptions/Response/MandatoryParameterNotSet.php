<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when mandatory parameter not set or invalid
 */
final class MandatoryParameterNotSet extends Base
{
    /**
     * @var int
     */
    protected $code = 341;
}
