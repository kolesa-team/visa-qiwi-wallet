<?php
namespace Qiwi\Exceptions\Response;

/**
 * Invalid argument exception
 */
class InvalidArgument extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 5;
}
