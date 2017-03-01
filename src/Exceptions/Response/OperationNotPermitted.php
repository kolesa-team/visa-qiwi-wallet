<?php
namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when operation not permitted
 */
class OperationNotPermitted extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 319;
}
