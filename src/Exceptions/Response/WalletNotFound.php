<?php
namespace Qiwi\Exceptions\Response;

/**
 * Wallet not found exception
 */
class WalletNotFound extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 298;
}
