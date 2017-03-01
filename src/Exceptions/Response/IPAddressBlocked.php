<?php
namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when ip-address blocked
 */
class IPAddressBlocked extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 339;
}
