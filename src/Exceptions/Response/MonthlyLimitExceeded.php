<?php
namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when monthly limit exceeded
 */
class MonthlyLimitExceeded extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 700;
}
