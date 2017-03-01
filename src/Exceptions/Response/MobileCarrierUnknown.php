<?php
namespace Qiwi\Exceptions\Response;

/**
 * Exception thrown when mobile carrier was not detected
 */
class MobileCarrierUnknown extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 1019;
}
