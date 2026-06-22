<?php

declare(strict_types=1);

namespace Qiwi\Test;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Qiwi\Entities\Base;
use Qiwi\Entities\Bill;
use Qiwi\Entities\Status;
use Qiwi\Interfaces\Entity;

class TestEntity extends TestCase
{
    /**
     * Test entity
     */
    protected Base $entity;

    protected function setUp(): void
    {
        $this->entity = new class extends Base {
            protected array $mandatoryFields = ['mandatory-field'];
        };
    }

    /**
     * Tests validation negative scenario
     *
     * @param array<mixed> $arguments
     */
    #[DataProvider('validateProvider')]
    public function testValidateNegative(string $method, array $arguments, string $exceptionClass): void
    {
        $reflection = new \ReflectionMethod($this->entity, $method);

        $this->expectException($exceptionClass);
        $reflection->invokeArgs($this->entity, $arguments);
    }

    /**
     * Test toArray method
     *
     * @param array<string, mixed> $expected
     */
    #[DataProvider('toArrayProvider')]
    public function testToArray(Entity $entity, array $expected): void
    {
        $actual = $entity->toArray();

        $this->assertIsArray($actual);
        foreach ($expected as $key => $value) {
            $this->assertArrayHasKey($key, $actual);
            $this->assertSame($value, $actual[$key]);
        }
    }

    /**
     * Test fromArray method
     *
     * @param class-string         $className
     * @param array<string, mixed> $input
     */
    #[DataProvider('fromArrayProvider')]
    public function testFromArray(string $className, array $input): void
    {
        /** @var Entity $entity */
        $entity = call_user_func([$className, 'fromArray'], $input);

        $this->assertInstanceOf($className, $entity);

        $actual = $entity->toArray();

        $this->assertIsArray($actual);
        foreach ($input as $key => $value) {
            $this->assertArrayHasKey($key, $actual);
            $this->assertSame($value, $actual[$key]);
        }
    }

    /**
     * Data-provider for validation test
     *
     * @return array<string, array{0: string, 1: array<mixed>, 2: string}>
     */
    public static function validateProvider(): array
    {
        return [
            'preValidate bool pattern'   => ['preValidate', ['string', false], \Qiwi\Exceptions\Validation\InvalidFormat::class],
            'preValidate bool value'     => ['preValidate', [false, 'string'], \Qiwi\Exceptions\Validation\InvalidFormat::class],
            'preValidate no match'       => ['preValidate', ['#\d+#u', 'string'], \Qiwi\Exceptions\Validation\InvalidFormat::class],
            'postValidate missing field' => ['postValidate', [['non-existent-field']], \Qiwi\Exceptions\Validation\EmptyParameter::class],
        ];
    }

    /**
     * Data-provider for toArray test
     *
     * @return array<int, array{0: Entity, 1: array<string, mixed>}>
     */
    public static function toArrayProvider(): array
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
     * @return array<int, array{0: class-string, 1: array<string, mixed>}>
     */
    public static function fromArrayProvider(): array
    {
        $ttl = new \DateTime('now', new \DateTimeZone('GMT+0600'));
        $ttl->add(new \DateInterval('PT1H'));

        return [
            [
                Bill::class,
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
                Status::class,
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
