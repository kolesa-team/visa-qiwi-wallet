<?php

declare(strict_types=1);

namespace Qiwi\Entities;

use Qiwi\Interfaces\Entity;

/**
 * Bill status entity
 */
final class Status extends Base implements Entity
{
    /**
     * @var string[]
     */
    protected array $mandatoryFields = [
        'bill_id',
        'amount',
        'ccy',
        'status',
        'error',
        'user',
        'comment',
    ];

    /**
     * Bill id
     */
    private string $billId;

    /**
     * Bill amount
     */
    private string $amount;

    /**
     * Bill currency
     */
    private string $currency;

    /**
     * Bill status
     */
    private string $status;

    /**
     * Error code
     */
    private string $error;

    /**
     * Bill user
     */
    private string $user;

    /**
     * Bill comment
     */
    private string $comment;

    public function getBillId(): string
    {
        return $this->billId;
    }

    /**
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function setBillId(string $billId): self
    {
        $this->preValidate('#^.{10,200}$#u', $billId);

        $this->billId = $billId;

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
        $this->preValidate('#^\d+(\.\d{0,3})?$#u', $amount);
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

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function setStatus(string $status): self
    {
        $this->preValidate('#^[a-z]{1,15}$#u', $status);

        $this->status = $status;

        return $this;
    }

    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public function setError(string $error): self
    {
        $this->preValidate('#^\d{1,4}$#u', $error);

        $this->error = $error;

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
        $this->preValidate('#^tel:\+\d{1,15}$#u', $user);

        $this->user = $user;

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

    /**
     * @return array<string, string>
     * @throws \Qiwi\Exceptions\Validation\EmptyParameter
     */
    public function toArray(): array
    {
        $result = [
            'bill_id' => $this->getBillId(),
            'amount'  => $this->getAmount(),
            'ccy'     => $this->getCurrency(),
            'status'  => $this->getStatus(),
            'error'   => $this->getError(),
            'user'    => $this->getUser(),
            'comment' => $this->getComment(),
        ];

        $this->postValidate($result);

        return $result;
    }

    /**
     * @param  array<string, mixed>                      $input
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    public static function fromArray(array $input): Status
    {
        $entity = new self();

        if (isset($input['bill_id'])) {
            $entity->setBillId(strval($input['bill_id']));
        }

        if (isset($input['amount'])) {
            $entity->setAmount(strval($input['amount']));
        }

        if (isset($input['ccy'])) {
            $entity->setCurrency(strval($input['ccy']));
        }

        if (isset($input['status'])) {
            $entity->setStatus(strval($input['status']));
        }

        if (isset($input['error'])) {
            $entity->setError(strval($input['error']));
        }

        if (isset($input['user'])) {
            $entity->setUser(strval($input['user']));
        }

        if (isset($input['comment'])) {
            $entity->setComment(strval($input['comment']));
        }

        return $entity;
    }
}
