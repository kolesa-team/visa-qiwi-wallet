<?php
namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when requested bill is being paid
 */
class BillInProgress extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 1419;
}
