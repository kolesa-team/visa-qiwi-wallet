<?php
namespace Qiwi\Exceptions\Response;

/**
 * Authorization exception
 */
class AuthorizationFailure extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 150;
}
