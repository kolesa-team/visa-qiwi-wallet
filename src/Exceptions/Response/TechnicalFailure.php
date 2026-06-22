<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Technical failure exception
 */
final class TechnicalFailure extends Base
{
    /**
     * @var int
     */
    protected $code = 300;
}
