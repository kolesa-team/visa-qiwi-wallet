<?php
namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when server is unavailable
 */
class ServerUnavailable extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 13;
}
