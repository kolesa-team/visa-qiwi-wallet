<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

/**
 * Invalid phone number exception
 */
final class InvalidPhoneNumber extends Base
{
    /**
     * @var int
     */
    protected $code = 303;
}
