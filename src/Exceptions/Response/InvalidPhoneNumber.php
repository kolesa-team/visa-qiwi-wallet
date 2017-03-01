<?php
namespace Qiwi\Exceptions\Response;

/**
 * Invalid phone number exception
 */
class InvalidPhoneNumber extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 303;
}
