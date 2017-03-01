<?php
namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when authorization attempt blocked
 */
class AuthorizationBlocked extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 316;
}
