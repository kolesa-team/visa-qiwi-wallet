<?php
namespace Qiwi\Test;

use Buzz\Browser;
use Buzz\Message\Response;
use PHPUnit\Framework\TestCase;
use Qiwi\Client;
use Qiwi\Entities\Bill;
use Qiwi\Entities\Status;

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

        $fakeBrowser = $this->createMock(Browser::class);
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
        $this->assertInstanceOf(Bill::class, $result);
    }

    /**
     * Check if bill status got
     */
    public function testBillStatus()
    {
        $result = $this->client->billStatus(str_pad('1', 10, '0', STR_PAD_LEFT));

        $this->assertNotFalse($result);
        $this->assertInstanceOf(Status::class, $result);
    }

    /**
     * Check if bill rejected
     */
    public function testBillReject()
    {
        $result = $this->client->billReject(str_pad('1', 10, '0', STR_PAD_LEFT));

        $this->assertNotFalse($result);
        $this->assertInstanceOf(Status::class, $result);
    }
}