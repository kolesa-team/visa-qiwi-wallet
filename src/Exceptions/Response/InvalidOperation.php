<?php
namespace Qiwi\Exceptions\Response;

/**
 * Invalid operation exception
 */
class InvalidOperation extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 78;
}
