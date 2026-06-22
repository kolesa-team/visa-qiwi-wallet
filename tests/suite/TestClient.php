<?php

declare(strict_types=1);

namespace Qiwi\Test;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Qiwi\Client;
use Qiwi\Entities\Bill;
use Qiwi\Entities\Status;
use Qiwi\Exceptions\Response\JSON;

/**
 * Main client test
 */
class TestClient extends TestCase
{
    /**
     * Make mock client
     *
     * @param array<mixed> $data
     */
    private function makeClient(array $data): Client
    {
        $mockHttp = $this->createStub(ClientInterface::class);
        $mockHttp->method('sendRequest')
            ->willReturn(new GuzzleResponse(200, [], (string) json_encode($data)));

        return new Client('1', 'login', 'password', 30, $mockHttp);
    }

    /**
     * Returns a response bill payload
     *
     * @return array<string, mixed>
     */
    private static function billPayload(string $billId, string $status): array
    {
        return [
            'response' => [
                'result_code' => 0,
                'bill'        => [
                    'bill_id' => $billId,
                    'amount'  => '99.95',
                    'ccy'     => 'USD',
                    'status'  => $status,
                    'error'   => 0,
                    'user'    => 'tel:+79161231212',
                    'comment' => 'Invoice from ShopName',
                ],
            ],
        ];
    }

    /**
     * Check if bill created
     */
    public function testCreateBill()
    {
        $client = $this->makeClient(self::billPayload('0000000001', 'waiting'));

        $ttl = new \DateTime();
        $ttl->add(new \DateInterval('PT1H'));

        $bill = (new Bill())
            ->setId(str_pad('1', 10, '0', STR_PAD_LEFT))
            ->setAccount('test account')
            ->setAmount('99.95')
            ->setComment('Invoice from ShopName')
            ->setCurrency('USD')
            ->setPaySource('qw')
            ->setLifetime($ttl->format('Y-m-d\TH:i:s'))
            ->setProviderName('Test provider')
            ->setUser('tel:+79161231212')
            ->setExtras(['A' => 'valueA', 'b' => 'valueB']);

        $result = $client->createBill($bill);

        $this->assertInstanceOf(Bill::class, $result);
    }

    /**
     * Check if bill status got
     */
    public function testBillStatus(): void
    {
        $client = $this->makeClient(self::billPayload('0000000002', 'paid'));
        $result = $client->billStatus(str_pad('1', 10, '0', STR_PAD_LEFT));

        $this->assertInstanceOf(Status::class, $result);
    }

    /**
     * Check if bill rejected
     */
    public function testBillReject(): void
    {
        $client = $this->makeClient(self::billPayload('0000000003', 'rejected'));
        $result = $client->billReject(str_pad('1', 10, '0', STR_PAD_LEFT));

        $this->assertInstanceOf(Status::class, $result);
    }

    /**
     * Check if JSON exception thrown on invalid response
     *
     * @param array<mixed>|string $data
     * @param string              $exceptionClass
     * @throws \PHPUnit\Framework\MockObject\Exception
     * @throws \ReflectionException
     */
    #[DataProvider('isResponseValidNegativeProvider')]
    public function testIsResponseValidNegative(array|string $data, string $exceptionClass): void
    {
        $mockHttp = $this->createStub(ClientInterface::class);
        $client   = new Client('1', 'login', 'password', 30, $mockHttp);

        $method = new \ReflectionMethod($client, 'isResponseValid');

        $this->expectException($exceptionClass);
        $method->invoke($client, $data);
    }

    public function testGetAuthorizationString(): void
    {
        $mockHttp = $this->createStub(ClientInterface::class);
        $client   = new Client('1', 'login', 'password', 30, $mockHttp);

        $method = new \ReflectionMethod($client, 'getAuthorizationString');
        $actual = $method->invoke($client, 'login', 'password');

        $this->assertSame('Basic bG9naW46cGFzc3dvcmQ=', $actual);
    }

    /**
     * Check if request headers are correct
     */
    public function testGetRequestHeaders(): void
    {
        $mockHttp = $this->createStub(ClientInterface::class);
        $client   = new Client('1', 'login', 'password', 30, $mockHttp);

        $method = new \ReflectionMethod($client, 'getRequestHeaders');
        $actual = $method->invoke($client);

        $this->assertIsArray($actual);
        $this->assertArrayHasKey('Authorization', $actual);
        $this->assertArrayHasKey('Accept', $actual);
        $this->assertSame('Basic bG9naW46cGFzc3dvcmQ=', $actual['Authorization']);
        $this->assertSame('text/json', $actual['Accept']);
    }

    /**
     * Check if data from Response was decoded correctly
     */
    public function testGetContent(): void
    {
        $mockHttp = $this->createStub(ClientInterface::class);
        $client   = new Client('1', 'login', 'password', 30, $mockHttp);

        $data     = self::billPayload('0000000003', 'rejected');
        $response = new GuzzleResponse(200, [], (string) json_encode($data));

        $method = new \ReflectionMethod($client, 'getContent');
        $actual = $method->invoke($client, $response);

        $this->assertIsArray($actual);
        $this->assertArrayHasKey('response', $actual);
        $this->assertArrayHasKey('result_code', $actual['response']);
        $this->assertArrayHasKey('bill', $actual['response']);
    }

    /**
     * Check if create bill and sends correct method
     */
    public function testCreateBillSendsCorrectMethod(): void
    {
        $capturedRequest = null;
        $mockHttp        = $this->createStub(ClientInterface::class);
        $mockHttp->method('sendRequest')
            ->willReturnCallback(function (RequestInterface $request) use (&$capturedRequest) {
                $capturedRequest = $request;

                return new GuzzleResponse(200, [], (string) json_encode(self::billPayload('0000000001', 'waiting')));
            });

        $client = new Client('1', 'login', 'password', 30, $mockHttp);

        $ttl  = (new \DateTime())->add(new \DateInterval('PT1H'));
        $bill = (new Bill())
            ->setId(str_pad('1', 10, '0', STR_PAD_LEFT))
            ->setAccount('test account')
            ->setAmount('99.95')
            ->setComment('Invoice from ShopName')
            ->setCurrency('USD')
            ->setPaySource('qw')
            ->setLifetime($ttl->format('Y-m-d\TH:i:s'))
            ->setUser('tel:+79161231212');

        $client->createBill($bill);

        $this->assertNotNull($capturedRequest);
        $this->assertSame('PUT', $capturedRequest->getMethod());
        $this->assertStringContainsString('prv/1/bills/', (string) $capturedRequest->getUri());
    }

    /**
     * Data-provider for negative test of isResponseValid
     *
     * @return array<string, array{0: array<mixed>|string, 1: string}>
     */
    public static function isResponseValidNegativeProvider(): array
    {
        return [
            'string input'            => ['invalid-data', JSON::class],
            'missing response key'    => [['result_code'], JSON::class],
            'response without fields' => [['response' => []], JSON::class],
            'missing bill field'      => [
                [
                    'response' => [
                        'result_code'    => 0,
                        'not_a_bill_key' => 'value',
                    ],
                ],
                JSON::class,
            ],
        ];
    }
}
