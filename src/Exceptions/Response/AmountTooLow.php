<?php
namespace Qiwi\Exceptions\Response;

/**
 * Amount too low exception
 */
class AmountTooLow extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 241;
}
