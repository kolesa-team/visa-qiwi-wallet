<?php
namespace Qiwi\Test;

use Buzz\Message\Response;
use PHPUnit\Framework\TestCase;
use Qiwi\Client;
use Qiwi\Entities\Bill;

/**
 * Main client test
 */
class TestClient extends TestCase
{
    /**
     * Test client
     *
     * @var \Qiwi\Client
     */
    protected $client;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->client = new Client('1', 'login', 'password');

        $submitResponse = new Response();
        $submitResponse->setContent(json_encode([
            'response' => [
                'result_code' => 0,
                'bill'        => [
                    'bill_id' => str_pad('1', 10, '0', STR_PAD_LEFT),
                    'amount'  => '99.95',
                    'ccy'     => 'USD',
                    'status'  => 'waiting',
                    'error'   => 0,
                    'user'    => 'tel:+79161231212',
                    'comment' => 'Invoice from ShopName',
                ],
            ],
        ]));

        $getResponse = new Response();
        $getResponse->setContent(json_encode([
            'response' => [
                'result_code' => 0,
                'bill'        => [
                    'bill_id' => str_pad('2', 10, '0', STR_PAD_LEFT),
                    'amount'  => '99.95',
                    'ccy'     => 'USD',
                    'status'  => 'paid',
                    'error'   => 0,
                    'user'    => 'tel:+79161231212',
                    'comment' => 'Invoice from ShopName',
                ],
            ]
        ]));

        $patchResponse = new Response();
        $patchResponse->setContent(json_encode([
            'response' => [
                'result_code' => 0,
                'bill'        => [
                    'bill_id' => str_pad('3', 10, '0', STR_PAD_LEFT),
                    'amount'  => '99.95',
                    'ccy'     => 'USD',
                    'status'  => 'rejected',
                    'error'   => 0,
                    'user'    => 'tel:+79161231212',
                    'comment' => 'Invoice from ShopName',
                ],
            ]
        ]));

        $fakeBrowser = $this->getMock('\Buzz\Browser', ['submit', 'get', 'patch']);
        $fakeBrowser->method('submit')->willReturn($submitResponse);
        $fakeBrowser->method('get')->willReturn($getResponse);
        $fakeBrowser->method('patch')->willReturn($patchResponse);


        $property = new \ReflectionProperty($this->client, 'browser');
        $property->setAccessible(true);

        $property->setValue($this->client, $fakeBrowser);
    }

    /**
     * Check if bill created
     */
    public function testCreateBill()
    {
        $ttl = new \DateTime();
        $ttl->add(new \DateInterval('PT1H'));

        $bill = new Bill();
        $bill->setId(str_pad('1', 10, '0', STR_PAD_LEFT))
            ->setAccount('test account')
            ->setAmount('99.95')
            ->setComment('Invoice from ShopName')
            ->setCurrency('USD')
            ->setPaySource('qw')
            ->setLifetime($ttl->format('Y-m-d\TH:i:s'))
            ->setProviderName('Test provider')
            ->setUser('tel:+79161231212');

        $result = $this->client->createBill($bill);

        $this->assertNotFalse($result);
        $this->assertInstanceOf('\Qiwi\Entities\Bill', $result);
    }

    /**
     * Check if bill status got
     */
    public function testBillStatus()
    {
        $result = $this->client->billStatus(str_pad('1', 10, '0', STR_PAD_LEFT));

        $this->assertNotFalse($result);
        $this->assertInstanceOf('\Qiwi\Entities\Status', $result);
    }

    /**
     * Check if bill rejected
     */
    public function testBillReject()
    {
        $result = $this->client->billReject(str_pad('1', 10, '0', STR_PAD_LEFT));

        $this->assertNotFalse($result);
        $this->assertInstanceOf('\Qiwi\Entities\Status', $result);
    }

    /**
     * Check if JSON exception thrown on invalid response
     *
     * @dataProvider \Qiwi\Test\TestClient::isResponseValidNegativeProvider
     * @param mixed  $data
     * @param string $exceptionClass
     */
    public function testIsResponseValidNegative($data, $exceptionClass)
    {
        $exception = null;
        $method    = new \ReflectionMethod($this->client, 'isResponseValid');
        $method->setAccessible(true);

        try {
            $method->invoke($this->client, $data);
        } catch (\Exception $e) {
            $exception = $e;
        }

        $this->assertNotNull($exception);
        $this->assertInstanceOf($exceptionClass, $exception);
    }

    /**
     * Check if authorization string is valid
     */
    public function testGetAuthorizationString()
    {
        $login    = 'login';
        $password = 'password';
        $expected = 'Basic bG9naW46cGFzc3dvcmQ=';
        $method   = new \ReflectionMethod($this->client, 'getAuthorizationString');
        $method->setAccessible(true);

        $actual = $method->invoke($this->client, $login, $password);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Check if request headers are correct
     */
    public function testGetRequestHeaders()
    {
        $method = new \ReflectionMethod($this->client, 'getRequestHeaders');
        $method->setAccessible(true);

        $actual = $method->invoke($this->client);
        $this->assertInternalType('array', $actual);
        $this->assertArrayHasKey('Authorization', $actual);
        $this->assertArrayHasKey('Accept', $actual);
        $this->assertEquals('Basic bG9naW46cGFzc3dvcmQ=', $actual['Authorization']);
        $this->assertEquals('text/json', $actual['Accept']);
    }

    /**
     * Check if data from Response was decoded correctly
     */
    public function testGetContent()
    {
        $data = [
            'response' => [
                'result_code' => 0,
                'bill'        => [
                    'bill_id' => str_pad('3', 10, '0', STR_PAD_LEFT),
                    'amount'  => '99.95',
                    'ccy'     => 'USD',
                    'status'  => 'rejected',
                    'error'   => 0,
                    'user'    => 'tel:+79161231212',
                    'comment' => 'Invoice from ShopName',
                ],
            ]
        ];

        $method = new \ReflectionMethod($this->client, 'getContent');
        $method->setAccessible(true);

        $response = new Response();
        $response->setContent(json_encode($data));

        $actual = $method->invoke($this->client, $response);
        $this->assertInternalType('array', $actual);
        $this->assertArraySubset($data, $actual);
    }

    /**
     * Data-provider for negative test of isResponseValid
     *
     * @return array
     */
    public function isResponseValidNegativeProvider()
    {
        return [
            ['invalid-data', '\Qiwi\Exceptions\Response\JSON'],
            [['result_code'], '\Qiwi\Exceptions\Response\JSON'],
            [['response'], '\Qiwi\Exceptions\Response\JSON'],
        ];
    }
}
