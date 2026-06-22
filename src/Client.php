<?php

declare(strict_types=1);

namespace Qiwi;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
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
     * Http client
     */
    protected ClientInterface $httpClient;

    /**
     * Authorization string.
     */
    protected string $authorization;

    /**
     * URL template for requests.
     */
    protected string $urlTemplate = 'https://qwproxy.qiwi.com/api/v2/prv/%s/bills/%s';

    public function __construct(
        protected string $providerId,
        string $login,
        string $password,
        int $timeout = 30,
        ?ClientInterface $httpClient = null,
    ) {
        $this->authorization = $this->getAuthorizationString($login, $password);
        $this->httpClient    = $httpClient ?? new GuzzleClient(['timeout' => $timeout]);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Qiwi\Exceptions\Response\Base
     * @throws \Qiwi\Exceptions\Response\JSON
     * @throws \Qiwi\Exceptions\Validation\EmptyParameter
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function createBill(Bill $bill): Bill
    {
        $url     = sprintf($this->urlTemplate, $this->providerId, $bill->getId());
        $request = new Request(
            'PUT',
            $url,
            array_merge($this->getRequestHeaders(), ['Content-Type' => 'application/x-www-form-urlencoded']),
            http_build_query($bill->toArray()),
        );
        $data = $this->getContent($this->httpClient->sendRequest($request));
        $this->isResponseValid($data);

        return Bill::fromArray($data['response']['bill']);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Qiwi\Exceptions\Response\Base
     * @throws \Qiwi\Exceptions\Response\JSON
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function billStatus(string $billId): Status
    {
        $url     = sprintf($this->urlTemplate, $this->providerId, $billId);
        $request = new Request('GET', $url, $this->getRequestHeaders());
        $data    = $this->getContent($this->httpClient->sendRequest($request));
        $this->isResponseValid($data);

        return Status::fromArray($data['response']['bill']);
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Qiwi\Exceptions\Response\Base
     * @throws \Qiwi\Exceptions\Response\JSON
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function billReject(string $billId): Status
    {
        $url     = sprintf($this->urlTemplate, $this->providerId, $billId);
        $request = new Request(
            'PATCH',
            $url,
            array_merge($this->getRequestHeaders(), ['Content-Type' => 'application/x-www-form-urlencoded']),
            'status=rejected',
        );
        $data = $this->getContent($this->httpClient->sendRequest($request));
        $this->isResponseValid($data);

        return Status::fromArray($data['response']['bill']);
    }

    protected function getAuthorizationString(string $login, string $password): string
    {
        return sprintf('Basic %s', base64_encode(sprintf('%s:%s', $login, $password)));
    }

    /**
     * Returns generic request headers.
     *
     * @return array<string, string>
     */
    protected function getRequestHeaders(): array
    {
        return [
            'Authorization' => $this->authorization,
            'Accept'        => 'text/json',
        ];
    }

    /**
     * Decodes message from json to array.
     *
     * @return array<mixed>|null
     */
    protected function getContent(ResponseInterface $response): ?array
    {
        return json_decode((string) $response->getBody(), true);
    }

    /**
     * Checks if response is valid.
     *
     * @phpstan-assert array{response: array{result_code: int, bill: array<string, mixed>}} $response
     * @throws JSON
     * @throws ResponseException
     */
    protected function isResponseValid(mixed $response): bool
    {
        if (!is_array($response) || !isset($response['response']) || !is_array($response['response'])) {
            throw new JSON();
        }

        $body = $response['response'];

        if (!isset($body['result_code']) || !isset($body['bill'])) {
            throw new JSON();
        }

        $description = (isset($body['description']) && is_string($body['description']))
            ? $body['description']
            : 'Unknown error';

        $exception = ResponseException::factory((int) $body['result_code'], $description);

        if ($exception !== null) {
            throw $exception;
        }

        return true;
    }
}
