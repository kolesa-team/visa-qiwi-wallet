<?php

declare(strict_types=1);

namespace Qiwi\Test;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Qiwi\Exceptions\Response\Base;

/**
 * Exception classes' test
 */
class TestException extends TestCase
{
    /**
     * Tests whether created exception is of correct type.
     */
    #[DataProvider('factoryMethodProvider')]
    public function testFactoryMethod(int $responseCode, string $className): void
    {
        $exception = Base::factory($responseCode);

        $this->assertNotNull($exception);
        $this->assertInstanceOf($className, $exception);
    }

    /**
     * Data-provider for factory method test.
     *
     * @return array<string, array{0: int, 1: class-string}>
     */
    public static function factoryMethodProvider(): array
    {
        return [
            'InvalidArgument'          => [5,    \Qiwi\Exceptions\Response\InvalidArgument::class],
            'ServerUnavailable'        => [13,   \Qiwi\Exceptions\Response\ServerUnavailable::class],
            'InvalidOperation'         => [78,   \Qiwi\Exceptions\Response\InvalidOperation::class],
            'AuthorizationFailure'     => [150,  \Qiwi\Exceptions\Response\AuthorizationFailure::class],
            'ProtocolUnavailable'      => [152,  \Qiwi\Exceptions\Response\ProtocolUnavailable::class],
            'BillNotFound'             => [210,  \Qiwi\Exceptions\Response\BillNotFound::class],
            'BillAlreadyExists'        => [215,  \Qiwi\Exceptions\Response\BillAlreadyExists::class],
            'AmountTooLow'             => [241,  \Qiwi\Exceptions\Response\AmountTooLow::class],
            'AmountTooHigh'            => [242,  \Qiwi\Exceptions\Response\AmountTooHigh::class],
            'WalletNotFound'           => [298,  \Qiwi\Exceptions\Response\WalletNotFound::class],
            'TechnicalFailure'         => [300,  \Qiwi\Exceptions\Response\TechnicalFailure::class],
            'InvalidPhoneNumber'       => [303,  \Qiwi\Exceptions\Response\InvalidPhoneNumber::class],
            'AuthorizationBlocked'     => [316,  \Qiwi\Exceptions\Response\AuthorizationBlocked::class],
            'OperationNotPermitted'    => [319,  \Qiwi\Exceptions\Response\OperationNotPermitted::class],
            'IPAddressBlocked'         => [339,  \Qiwi\Exceptions\Response\IPAddressBlocked::class],
            'MandatoryParameterNotSet' => [341, \Qiwi\Exceptions\Response\MandatoryParameterNotSet::class],
            'MonthlyLimitExceeded'     => [700,  \Qiwi\Exceptions\Response\MonthlyLimitExceeded::class],
            'WalletBlocked'            => [774,  \Qiwi\Exceptions\Response\WalletBlocked::class],
            'CurrencyNotPermitted'     => [1001, \Qiwi\Exceptions\Response\CurrencyNotPermitted::class],
            'CurrencyRateUnavailable'  => [1003, \Qiwi\Exceptions\Response\CurrencyRateUnavailable::class],
            'MobileCarrierUnknown'     => [1019, \Qiwi\Exceptions\Response\MobileCarrierUnknown::class],
            'BillInProgress'           => [1419, \Qiwi\Exceptions\Response\BillInProgress::class],
        ];
    }
}
