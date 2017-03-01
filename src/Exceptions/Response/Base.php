<?php
namespace Qiwi\Exceptions\Response;

use Qiwi\Exceptions\Base as BaseException;

/**
 * Base response exception
 */
abstract class Base extends BaseException
{
    /**
     * @param  integer                        $responseCode
     * @return \Qiwi\Exceptions\Response\Base
     */
    public static function factory($responseCode)
    {
        switch ($responseCode) {
            case 5:
                return new InvalidArgument();
            case 13:
                return new ServerUnavailable();
            case 78:
                return new InvalidOperation();
            case 150:
                return new AuthorizationFailure();
            case 152:
                return new ProtocolUnavailable();
            case 210:
                return new BillNotFound();
            case 215:
                return new BillAlreadyExists();
            case 241:
                return new AmountTooLow();
            case 242:
                return new AmountTooHigh();
            case 298:
                return new WalletNotFound();
            case 300:
                return new TechnicalFailure();
            case 303:
                return new InvalidPhoneNumber();
            case 316:
                return new AuthorizationBlocked();
            case 319:
                return new OperationNotPermitted();
            case 339:
                return new IPAddressBlocked();
            case 341:
                return new MandatoryParameterNotSet();
            case 700:
                return new MonthlyLimitExceeded();
            case 774:
                return new WalletBlocked();
            case 1001:
                return new CurrencyNotPermitted();
            case 1003:
                return new CurrencyRateUnavailable();
            case 1019:
                return new MobileCarrierUnknown();
            case 1419:
                return new BillInProgress();
        }

        return null;
    }
}
