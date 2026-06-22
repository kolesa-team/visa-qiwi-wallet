<?php

declare(strict_types=1);

namespace Qiwi\Exceptions\Response;

use Qiwi\Exceptions\Base as BaseException;

/**
 * Base response exception
 */
abstract class Base extends BaseException
{
    public static function factory(int $responseCode, string $description = ''): ?self
    {
        return match ($responseCode) {
            5       => new InvalidArgument($description),
            13      => new ServerUnavailable($description),
            78      => new InvalidOperation($description),
            150     => new AuthorizationFailure($description),
            152     => new ProtocolUnavailable($description),
            210     => new BillNotFound($description),
            215     => new BillAlreadyExists($description),
            241     => new AmountTooLow($description),
            242     => new AmountTooHigh($description),
            298     => new WalletNotFound($description),
            300     => new TechnicalFailure($description),
            303     => new InvalidPhoneNumber($description),
            316     => new AuthorizationBlocked($description),
            319     => new OperationNotPermitted($description),
            339     => new IPAddressBlocked($description),
            341     => new MandatoryParameterNotSet($description),
            700     => new MonthlyLimitExceeded($description),
            774     => new WalletBlocked($description),
            1001    => new CurrencyNotPermitted($description),
            1003    => new CurrencyRateUnavailable($description),
            1019    => new MobileCarrierUnknown($description),
            1419    => new BillInProgress($description),
            default => null,
        };
    }
}
