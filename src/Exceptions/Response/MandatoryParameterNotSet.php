<?php
namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when mandatory parameter not set or invalid
 */
class MandatoryParameterNotSet extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 341;
}
