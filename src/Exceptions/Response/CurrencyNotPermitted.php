<?php
namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when requested currency is not permitted
 */
class CurrencyNotPermitted extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 1001;
}
