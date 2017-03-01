<?php
namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when wallet blocked
 */
class WalletBlocked extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 774;
}
