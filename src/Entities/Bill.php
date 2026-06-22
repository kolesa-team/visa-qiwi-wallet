<?php

declare(strict_types=1);

namespace Qiwi\Entities;

use Qiwi\Interfaces\Entity;

/**
 * Bill entity
 */
final class Bill extends Base implements Entity
{
    /**
     * @var string[]
     */
    protected array $mandatoryFields = [
        'user',
        'amount',
        'ccy',
        'comment',
        'lifetime',
        'account',
    ];

    /**
     * Bill id
     */
    private string $id;

    /**
     * User telephone number
     */
    private string $user;

    /**
     * Bill amount
     */
    private string $amount;

    /**
     * Bill currency
     */
    private string $currency;

    /**
     * Bill comment
     */
    private string $comment;

    /**
     * Bill lifetime
     */
    private \DateTime $lifetime;

    /**
     * User account
     */
    private string $account;

    /**
     * Payment source [mobile, qw]
     */
    private string $paySource = 'mobile';

    /**
     * Provider name
     */
    private ?string $providerName = null;

    /**
     * Bill extra parameters.
     *
     * @var array<string, string>|null
     */
    private ?array $extras = null;

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function setId(string $id): self
    {
        $this->preValidate('#^.{10,200}$#u', $id);

        $this->id = $id;

        return $this;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function setUser(string $user): self
    {
        $this->preValidate('#tel:\+\d{1,15}$#u', $user);

        $this->user = $user;

        return $this;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function setAmount(string $amount): self
    {
        $this->preValidate('#^\d+(.\d{0,3})?$#u', $amount);

        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function setCurrency(string $currency): self
    {
        $this->preValidate('#^[a-zA-Z]{3}$#u', $currency);

        $this->currency = $currency;

        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function setComment(string $comment): self
    {
        $this->preValidate('#^.{0,255}$#u', $comment);

        $this->comment = $comment;

        return $this;
    }

    public function getLifetime(): \DateTime
    {
        return $this->lifetime;
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function setLifetime(string $lifetime): self
    {
        $this->preValidate('#^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}$#u', $lifetime);

        $this->lifetime = new \DateTime($lifetime, new \DateTimeZone('GMT+0300'));

        return $this;
    }

    public function getAccount(): string
    {
        return $this->account;
    }

    /**
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function setAccount(string $account): self
    {
        $this->preValidate('#^.{0,100}$#u', $account);

        $this->account = $account;

        return $this;
    }

    public function getPaySource(): string
    {
        return $this->paySource;
    }

    public function setPaySource(string $paySource): self
    {
        $this->preValidate('#^((mobile)|(qw)){1}$#u', $paySource);
        $this->paySource = $paySource;

        return $this;
    }

    public function getProviderName(): ?string
    {
        return $this->providerName;
    }

    public function setProviderName(string $providerName): self
    {
        $this->preValidate('#^.{1,100}$#u', $providerName);

        $this->providerName = $providerName;

        return $this;
    }

    /** @return array<string, string>|null */
    public function getExtras(): ?array
    {
        return $this->extras;
    }

    /**
     * @param  array<string, string>                     $extras
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function setExtras(array $extras): static
    {
        array_walk($extras, function (mixed $value): void {
            $this->preValidate('#^.{0,500}$#u', $value);
        });

        $this->extras = $extras;

        return $this;
    }

    /**
     * @return array<string, string>
     * @throws \Qiwi\Exceptions\Validation\EmptyParameter
     */
    #[\Override]
    public function toArray(): array
    {
        $result = [
            'user'       => $this->getUser(),
            'amount'     => $this->getAmount(),
            'ccy'        => $this->getCurrency(),
            'comment'    => $this->getComment(),
            'lifetime'   => $this->getLifetime()->format('Y-m-d\TH:i:s'),
            'account'    => $this->getAccount(),
            'pay_source' => $this->getPaySource(),
        ];

        if ($this->getProviderName() !== null) {
            $result['prv_name'] = $this->getProviderName();
        }

        if ($this->getExtras() !== null) {
            foreach ($this->getExtras() as $key => $value) {
                $result['extras[' . $key . ']'] = $value;
            }
        }

        $this->postValidate($result);

        return $result;
    }

    /**
     * @param  array<string, mixed>                      $input
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    #[\Override]
    public static function fromArray(array $input): Bill
    {
        $entity = new self();

        if (isset($input['user'])) {
            $entity->setUser(strval($input['user']));
        }

        if (isset($input['amount'])) {
            $entity->setAmount(strval($input['amount']));
        }

        if (isset($input['ccy'])) {
            $entity->setCurrency(strval($input['ccy']));
        }

        if (isset($input['comment'])) {
            $entity->setComment(strval($input['comment']));
        }

        if (isset($input['lifetime'])) {
            $entity->setLifetime(strval($input['lifetime']));
        }
        if (isset($input['account'])) {
            $entity->setAccount(strval($input['account']));
        }
        if (isset($input['pay_source'])) {
            $entity->setPaySource(strval($input['pay_source']));
        }
        if (isset($input['prv_name'])) {
            $entity->setProviderName(strval($input['prv_name']));
        }

        $extras = [];

        foreach ($input as $key => $value) {
            if (str_starts_with($key, 'extras')) {
                $extras[substr($key, 7, -1)] = strval($value);
            }
        }

        if ($extras !== []) {
            $entity->setExtras($extras);
        }

        return $entity;
    }
}
