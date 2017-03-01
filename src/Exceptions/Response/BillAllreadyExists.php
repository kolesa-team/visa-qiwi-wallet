<?php
namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when bill already exists
 */
class BillAllreadyExists extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 215;
}
