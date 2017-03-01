<?php
namespace Qiwi;

use Buzz\Browser;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Qiwi\Entities\Bill;
use Qiwi\Entities\Status;
use Qiwi\Exceptions\Response\Base as ResponseException;
use Qiwi\Exceptions\Response\JSON;

/**
 * Base client class.
 */
class Client
{
    /**
     * Browser client.
     *
     * @var \Buzz\Client\ClientInterface
     */
    protected $browser;

    /**
     * Provider id.
     *
     * @var string
     */
    protected $providerId;

    /**
     * Authorization string.
     *
     * @var string
     */
    protected $authorization;

    /**
     * URL template for requests.
     *
     * @var string
     */
    protected $urlTemplate = 'https://qwproxy.qiwi.com/api/v2/prv/%s/bills/%s';

    /**
     * Constructor.
     *
     * @param string $providerId
     * @param string $login
     * @param string $password
     */
    public function __construct($providerId, $login, $password)
    {
        $this->providerId    = $providerId;
        $this->authorization = $this->getAuthorizationString($login, $password);
        $this->browser       = new Browser();
    }

    /**
     * Creates bill in Qiwi Wallet system.
     *
     * @param  \Qiwi\Entities\Bill $bill
     * @return \Qiwi\Entities\Bill
     */
    public function createBill(Bill $bill)
    {
        $url      = sprintf('/api/v2/prv/%s/bills/%s', $this->providerId, $bill->getId());
        $response = $this->browser->submit(
            $url,
            $bill->toArray(),
            RequestInterface::METHOD_PUT,
            $this->getRequestHeaders()
        );
        $response = $this->getContent($response);

        if ($this->isResponseValid($response)) {
            $result = new Bill();

            $result->fromArray($response['bill']);

            return $result;
        }

        return false;
    }

    /**
     * Returns bill status.
     *
     * @param  string                      $billId
     * @return \Qiwi\Entities\Status|false
     */
    public function billStatus($billId)
    {
        $url      = sprintf($this->urlTemplate, $this->providerId, $billId);
        $response = $this->browser->get($url, $this->getRequestHeaders());
        $response = $this->getContent($response);

        if ($this->isResponseValid($response)) {
            $result = new Status();

            $result->fromArray($response['bill']);

            return $result;
        }

        return false;
    }

    /**
     * Rejects unpaid bill.
     *
     * @param  string              $billId
     * @return \Qiwi\Entities\Bill
     */
    public function billReject($billId)
    {
        $url      = sprintf($this->urlTemplate, $this->providerId, $billId);
        $response = $this->browser->patch($url, $this->getRequestHeaders(), 'status=rejected');
        $response = $this->getContent($response);

        if ($this->isResponseValid($response)) {
            $result = new Bill();

            $result->fromArray($response['bill']);

            return $result;
        }

        return false;
    }

    /**
     * Returns string for basic-authorization.
     *
     * @param  string $login
     * @param  string $password
     * @return string
     */
    protected function getAuthorizationString($login, $password)
    {
        return sprintf("Basic %s", base64_encode(sprintf("%s:%s", $login, $password)));
    }

    /**
     * Returns generic request headers.
     *
     * @return array
     */
    protected function getRequestHeaders()
    {
        return [
            'Authorization' => $this->authorization,
            'Accept'        => 'text/json',
        ];
    }

    /**
     * Decodes message from json to array.
     *
     * @param  \Buzz\Message\MessageInterface $response
     * @return array|null
     */
    protected function getContent(MessageInterface $response)
    {
        $content = $response->getContent();

        return json_decode($content, true);
    }

    /**
     * Checks if response is valid.
     *
     * @param  mixed                          $response
     * @return boolean
     * @throws \Qiwi\Exceptions\Response\Base
     */
    protected function isResponseValid($response)
    {
        if (!is_array($response) || !isset($response['result_code'])) {
            $exception = new JSON();
        } else {
            $exception = ResponseException::factory($response['result_code']);
        }

        if ($exception !== null) {
            throw $exception;
        }

        return true;
    }
}
