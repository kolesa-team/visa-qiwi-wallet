<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when mobile carrier was not detected
 */
final class MobileCarrierUnknown extends Base
{
    /**
     * @var int
     */
    protected $code = 1019;
}
