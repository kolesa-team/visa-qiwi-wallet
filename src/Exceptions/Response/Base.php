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
     * @param  string                         $description
     * @return \Qiwi\Exceptions\Response\Base
     */
    public static function factory($responseCode, $description)
    {
        switch ($responseCode) {
            case 5:
                return new InvalidArgument($description);
            case 13:
                return new ServerUnavailable($description);
            case 78:
                return new InvalidOperation($description);
            case 150:
                return new AuthorizationFailure($description);
            case 152:
                return new ProtocolUnavailable($description);
            case 210:
                return new BillNotFound($description);
            case 215:
                return new BillAlreadyExists($description);
            case 241:
                return new AmountTooLow($description);
            case 242:
                return new AmountTooHigh($description);
            case 298:
                return new WalletNotFound($description);
            case 300:
                return new TechnicalFailure($description);
            case 303:
                return new InvalidPhoneNumber($description);
            case 316:
                return new AuthorizationBlocked($description);
            case 319:
                return new OperationNotPermitted($description);
            case 339:
                return new IPAddressBlocked($description);
            case 341:
                return new MandatoryParameterNotSet($description);
            case 700:
                return new MonthlyLimitExceeded($description);
            case 774:
                return new WalletBlocked($description);
            case 1001:
                return new CurrencyNotPermitted($description);
            case 1003:
                return new CurrencyRateUnavailable($description);
            case 1019:
                return new MobileCarrierUnknown($description);
            case 1419:
                return new BillInProgress($description);
        }

        return null;
    }
}
