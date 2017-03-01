<?php
namespace Qiwi\Exceptions\Response;

/**
 * Amount too high exception
 */
class AmountTooHigh extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 242;
}
