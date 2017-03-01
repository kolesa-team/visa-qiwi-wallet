<?php
namespace Qiwi\Exceptions\Response;

/**
 * Technical failure exception
 */
class TechnicalFailure extends Base
{
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = 300;
}
