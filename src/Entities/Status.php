<?php
namespace Qiwi\Entities;

use Qiwi\Interfaces\Entity;

/**
 * Bill status entity
 */
class Status extends Base implements Entity
{
    /**
     * {@inheritdoc}
     *
     * @var array
     */
    protected $mandatoryFields = [
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
     *
     * @var string
     */
    protected $billId;

    /**
     * Bill amount
     *
     * @var string
     */
    protected $amount;

    /**
     * Bill currency
     *
     * @var string
     */
    protected $currency;

    /**
     * Bill status
     *
     * @var string
     */
    protected $status;

    /**
     * Error code
     *
     * @var string
     */
    protected $error;

    /**
     * Bill user
     *
     * @var string
     */
    protected $user;

    /**
     * Bill comment
     *
     * @var string
     */
    protected $comment;

    /**
     * {@see \Qiwi\Entities\Status::$billId}
     *
     * @return string
     */
    public function getBillId()
    {
        return $this->billId;
    }

    /**
     * {@see \Qiwi\Entities\Status::$billId}
     *
     * @param  string                $billId
     * @return \Qiwi\Entities\Status
     */
    public function setBillId($billId)
    {
        $this->preValidate('#^.{10,200}$#u', $billId);

        $this->billId = $billId;

        return $this;
    }

    /**
     * {@see \Qiwi\Entities\Status::$amount}
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * {@see \Qiwi\Entities\Status::$amount}
     *
     * @param  string                $amount
     * @return \Qiwi\Entities\Status
     */
    public function setAmount($amount)
    {
        $this->preValidate('#^\d+(\.\d{0,3})?$#u', $amount);

        $this->amount = $amount;

        return $this;
    }

    /**
     * {@see \Qiwi\Entities\Status::$currency}
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * {@see \Qiwi\Entities\Status::$currency}
     *
     * @param  string                $currency
     * @return \Qiwi\Entities\Status
     */
    public function setCurrency($currency)
    {
        $this->preValidate('#^[a-zA-Z]{3}$#u', $currency);

        $this->currency = $currency;

        return $this;
    }

    /**
     * {@see \Qiwi\Entities\Status::$status}
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@see \Qiwi\Entities\Status::$status}
     *
     * @param  string                $status
     * @return \Qiwi\Entities\Status
     */
    public function setStatus($status)
    {
        $this->preValidate('#^[a-z]{1,15}$#u', $status);

        $this->status = $status;

        return $this;
    }

    /**
     * {@see \Qiwi\Entities\Status::$error}
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * {@see \Qiwi\Entities\Status::$error}
     *
     * @param  string                $error
     * @return \Qiwi\Entities\Status
     */
    public function setError($error)
    {
        $this->preValidate('#^\d{1,4}$#u', $error);

        $this->error = $error;

        return $this;
    }

    /**
     * {@see \Qiwi\Entities\Status::$user}
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@see \Qiwi\Entities\Status::$user}
     *
     * @param  string                $user
     * @return \Qiwi\Entities\Status
     */
    public function setUser($user)
    {
        $this->preValidate('#^tel:\+\d{1,15}$#u', $user);

        $this->user = $user;

        return $this;
    }

    /**
     * {@see \Qiwi\Entities\Status::$comment}
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * {@see \Qiwi\Entities\Status::$comment}
     *
     * @param  string                $comment
     * @return \Qiwi\Entities\Status
     */
    public function setComment($comment)
    {
        $this->preValidate('#^.{0,255}$#u', $comment);

        $this->comment = $comment;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function toArray()
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

        $result = array_filter($result);

        $this->postValidate($result);

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @param  array                 $input
     * @return \Qiwi\Entities\Status
     */
    public static function fromArray(array $input)
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
