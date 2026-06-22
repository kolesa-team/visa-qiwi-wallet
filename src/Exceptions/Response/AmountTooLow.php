<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Amount too low exception
 */
final class AmountTooLow extends Base
{
    /**
     * @var int
     */
    protected $code = 241;
}
