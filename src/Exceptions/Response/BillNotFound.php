<?php
namespace Qiwi\Exceptions\Response;

/**
 * Bill not found exception
 */
class BillNotFound extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 210;
}
