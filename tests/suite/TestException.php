<?php
namespace Qiwi\Test;

use PHPUnit\Framework\TestCase;
use Qiwi\Exceptions\Response\Base;

/**
 * Exception classes' test
 */
class TestException extends TestCase
{
    /**
     * Tests whether created exception is of correct type.
     *
     * @dataProvider \Qiwi\Test\TestException::factoryMethodProvider
     * @param integer $responseCode
     * @param string  $className
     */
    public function testFactoryMethod($responseCode, $className)
    {
        $exception = Base::factory($responseCode);

        $this->assertNotNull($exception);
        $this->assertInstanceOf($className, $exception);
    }

    /**
     * Data-provider for factory method test.
     *
     * @return array
     */
    public function factoryMethodProvider()
    {
        return [
            [5,    '\Qiwi\Exceptions\Response\InvalidArgument'],
            [13,   '\Qiwi\Exceptions\Response\ServerUnavailable'],
            [78,   '\Qiwi\Exceptions\Response\InvalidOperation'],
            [150,  '\Qiwi\Exceptions\Response\AuthorizationFailure'],
            [152,  '\Qiwi\Exceptions\Response\ProtocolUnavailable'],
            [210,  '\Qiwi\Exceptions\Response\BillNotFound'],
            [215,  '\Qiwi\Exceptions\Response\BillAlreadyExists'],
            [241,  '\Qiwi\Exceptions\Response\AmountTooLow'],
            [242,  '\Qiwi\Exceptions\Response\AmountTooHigh'],
            [298,  '\Qiwi\Exceptions\Response\WalletNotFound'],
            [300,  '\Qiwi\Exceptions\Response\TechnicalFailure'],
            [303,  '\Qiwi\Exceptions\Response\InvalidPhoneNumber'],
            [316,  '\Qiwi\Exceptions\Response\AuthorizationBlocked'],
            [319,  '\Qiwi\Exceptions\Response\OperationNotPermitted'],
            [339,  '\Qiwi\Exceptions\Response\IPAddressBlocked'],
            [341,  '\Qiwi\Exceptions\Response\MandatoryParameterNotSet'],
            [700,  '\Qiwi\Exceptions\Response\MonthlyLimitExceeded'],
            [774,  '\Qiwi\Exceptions\Response\WalletBlocked'],
            [1001, '\Qiwi\Exceptions\Response\CurrencyNotPermitted'],
            [1003, '\Qiwi\Exceptions\Response\CurrencyRateUnavailable'],
            [1019, '\Qiwi\Exceptions\Response\MobileCarrierUnknown'],
            [1419, '\Qiwi\Exceptions\Response\BillInProgress'],
        ];
    }
}
