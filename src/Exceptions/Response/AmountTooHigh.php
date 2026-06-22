<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Amount too high exception
 */
final class AmountTooHigh extends Base
{
    /**
     * @var int
     */
    protected $code = 242;
}
