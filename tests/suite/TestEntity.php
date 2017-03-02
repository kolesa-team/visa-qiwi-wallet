<?php
namespace Qiwi\Test;

use PHPUnit\Framework\TestCase;
use Qiwi\Entities\Bill;
use Qiwi\Entities\Status;
use Qiwi\Interfaces\Entity;

class TestEntity extends TestCase
{
    /**
     * Test entity
     *
     * @var \Qiwi\Entities\Base
     */
    protected $entity;

    public function setUp()
    {
        $this->entity = $this->getMockForAbstractClass('\Qiwi\Entities\Base');

        $property = new \ReflectionProperty($this->entity, 'mandatoryFields');
        $property->setAccessible(true);
        $property->setValue($this->entity, ['mandatory-field']);
    }

    /**
     * Tests validation negative scenario
     *
     * @dataProvider \Qiwi\Test\TestEntity::validateProvider
     * @param string $method
     * @param array  $arguments
     * @param string $exceptionClass
     */
    public function testValidateNegative($method, array $arguments, $exceptionClass)
    {
        $exception = null;
        $method    = new \ReflectionMethod($this->entity, $method);
        $method->setAccessible(true);

        try {
            $method->invokeArgs($this->entity, $arguments);
        } catch (\Exception $e) {
            $exception = $e;
        }

        $this->assertNotNull($exception);
        $this->assertInstanceOf('\Qiwi\Exceptions\Validation\Base', $exception);
        $this->assertInstanceOf($exceptionClass, $exception);
    }

    /**
     * Test toArray method
     *
     * @dataProvider \Qiwi\Test\TestEntity::toArrayProvider
     * @param \Qiwi\Interfaces\Entity $entity
     * @param array                   $expected
     */
    public function testToArray(Entity $entity, array $expected)
    {
        $actual = $entity->toArray();

        $this->assertInternalType('array', $actual);
        $this->assertArraySubset($expected, $actual);
    }

    /**
     * Test fromArray method
     *
     * @dataProvider \Qiwi\Test\TestEntity::fromArrayProvider
     * @param string $className
     * @param array  $input
     */
    public function testFromArray($className, array $input)
    {
        /** @var \Qiwi\Interfaces\Entity $entity */
        $entity = call_user_func([$className, 'fromArray'], $input);

        $this->assertInstanceOf($className, $entity);

        $actual = $entity->toArray();

        $this->assertInternalType('array', $actual);
        $this->assertArraySubset($input, $actual);
    }

    /**
     * Data-provider for validation test
     *
     * @return array
     */
    public function validateProvider()
    {
        return [
            ['preValidate', ['string', false], '\Qiwi\Exceptions\Validation\InvalidFormat'],
            ['preValidate', [false, 'string'], '\Qiwi\Exceptions\Validation\InvalidFormat'],
            ['preValidate', ['#\d+#u', 'string'], '\Qiwi\Exceptions\Validation\InvalidFormat'],
            ['postValidate', [['non-existent-field']], '\Qiwi\Exceptions\Validation\EmptyParameter'],
        ];
    }

    /**
     * Data-provider for toArray test
     *
     * @return array
     */
    public function toArrayProvider()
    {
        $ttl = new \DateTime('now', new \DateTimeZone('GMT+0600'));
        $ttl->add(new \DateInterval('PT1H'));

        return [
            [
                (new Bill())->setId(str_pad('1', 10, '0', STR_PAD_LEFT))
                    ->setProviderName('ShopName')
                    ->setPaySource('qw')
                    ->setCurrency('KZT')
                    ->setAmount('99.95')
                    ->setAccount('123456')
                    ->setUser('tel:+79161231212')
                    ->setLifetime($ttl->format('Y-m-d\TH:i:s'))
                    ->setExtras(['a' => 'valueA', 'b' => 'valueB'])
                    ->setComment('Invoice from ShopName'),
                [
                    'user'       => 'tel:+79161231212',
                    'amount'     => '99.95',
                    'ccy'        => 'KZT',
                    'comment'    => 'Invoice from ShopName',
                    'lifetime'   => $ttl->format('Y-m-d\TH:i:s'),
                    'account'    => '123456',
                    'pay_source' => 'qw',
                    'prv_name'   => 'ShopName',
                    'extras[a]'  => 'valueA',
                    'extras[b]'  => 'valueB',
                ],
            ],
            [
                (new Status())->setBillId(str_pad('1', 10, '0', STR_PAD_LEFT))
                    ->setCurrency('KZT')
                    ->setAmount('99.95')
                    ->setError('0')
                    ->setStatus('waiting')
                    ->setUser('tel:+79161231212')
                    ->setComment('Invoice from ShopName'),
                [
                    'bill_id' => str_pad('1', 10, '0', STR_PAD_LEFT),
                    'amount'  => '99.95',
                    'ccy'     => 'KZT',
                    'status'  => 'waiting',
                    'error'   => '0',
                    'user'    => 'tel:+79161231212',
                    'comment' => 'Invoice from ShopName',
                ],
            ],
        ];
    }

    /**
     * Data-provider for fromArray test
     *
     * @return array
     */
    public function fromArrayProvider()
    {
        $ttl = new \DateTime('now', new \DateTimeZone('GMT+0600'));
        $ttl->add(new \DateInterval('PT1H'));

        return [
            [
                '\Qiwi\Entities\Bill',
                [
                    'user'       => 'tel:+79161231212',
                    'amount'     => '99.95',
                    'ccy'        => 'KZT',
                    'comment'    => 'Invoice from ShopName',
                    'lifetime'   => $ttl->format('Y-m-d\TH:i:s'),
                    'account'    => '123456',
                    'pay_source' => 'qw',
                    'prv_name'   => 'ShopName',
                    'extras[a]'  => 'valueA',
                    'extras[b]'  => 'valueB',
                ],
            ],
            [
                '\Qiwi\Entities\Status',
                [
                    'bill_id' => str_pad('1', 10, '0', STR_PAD_LEFT),
                    'amount'  => '99.95',
                    'ccy'     => 'KZT',
                    'status'  => 'waiting',
                    'error'   => '0',
                    'user'    => 'tel:+79161231212',
                    'comment' => 'Invoice from ShopName',
                ],
            ],
        ];
    }
}
