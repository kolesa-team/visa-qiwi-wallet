<?php
namespace Qiwi\Entities;

use Qiwi\Interfaces\Entity;

/**
 * Bill entity
 */
class Bill extends Base implements Entity
{
    /**
     * {@inheritdoc}
     *
     * @var array
     */
    protected $mandatoryFields = [
        'user',
        'amount',
        'ccy',
        'comment',
        'lifetime',
        'account',
    ];

    /**
     * Bill id
     *
     * @var string
     */
    protected $id;

    /**
     * User telephone number
     *
     * @var string
     */
    protected $user;

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
     * Bill comment
     *
     * @var string
     */
    protected $comment;

    /**
     * Bill lifetime
     *
     * @var \DateTime
     */
    protected $lifetime;

    /**
     * User account
     *
     * @var string
     */
    protected $account;

    /**
     * Payment source [mobile, qw]
     *
     * @var string
     */
    protected $paySource = 'mobile';

    /**
     * Provider name
     *
     * @var string
     */
    protected $providerName;

    /**
     * Bill extra parameters.
     *
     * @var array
     */
    protected $extras;

    /**
     * {@see \Qiwi\Entity\Bill::$id}
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$id}
     *
     * @param  string              $id
     * @return \Qiwi\Entities\Bill
     */
    public function setId($id)
    {
        $this->preValidate('#^.{10,200}$#u', $id);

        $this->id = $id;

        return $this;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$user}
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$user}
     *
     * @param  string              $user
     * @return \Qiwi\Entities\Bill
     */
    public function setUser($user)
    {
        $this->preValidate('#tel:\+\d{1,15}$#u', $user);

        $this->user = $user;

        return $this;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$amount}
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$amount}
     *
     * @param  string              $amount
     * @return \Qiwi\Entities\Bill
     */
    public function setAmount($amount)
    {
        $this->preValidate('#^\d+(.\d{0,3})?$#u', $amount);

        $this->amount = $amount;

        return $this;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$currency}
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$currency}
     *
     * @param  string              $currency
     * @return \Qiwi\Entities\Bill
     */
    public function setCurrency($currency)
    {
        $this->preValidate('#^[a-zA-Z]{3}$#u', $currency);

        $this->currency = $currency;

        return $this;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$comment}
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$comment}
     *
     * @param  string              $comment
     * @return \Qiwi\Entities\Bill
     */
    public function setComment($comment)
    {
        $this->preValidate('#^.{0,255}$#u', $comment);

        $this->comment = $comment;

        return $this;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$lifetime}
     *
     * @return \DateTime
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$lifetime}
     *
     * @param  string              $lifetime
     * @return \Qiwi\Entities\Bill
     */
    public function setLifetime($lifetime)
    {
        $this->preValidate('#^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}$#u', $lifetime);

        $this->lifetime = new \DateTime($lifetime, new \DateTimeZone('GMT+0300'));

        return $this;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$account}
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$account}
     *
     * @param  string              $account
     * @return \Qiwi\Entities\Bill
     */
    public function setAccount($account)
    {
        $this->preValidate('#^.{0,100}$#u', $account);

        $this->account = $account;

        return $this;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$paySource}
     *
     * @return string
     */
    public function getPaySource()
    {
        return $this->paySource;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$paySource}
     *
     * @param  string              $paySource
     * @return \Qiwi\Entities\Bill
     */
    public function setPaySource($paySource)
    {
        $this->preValidate('#^((mobile)|(qw)){1}$#u', $paySource);

        $this->paySource = $paySource;

        return $this;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$providerName}
     *
     * @return string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$providerName}
     *
     * @param  string              $providerName
     * @return \Qiwi\Entities\Bill
     */
    public function setProviderName($providerName)
    {
        $this->preValidate('#^.{1,100}$#u', $providerName);

        $this->providerName = $providerName;

        return $this;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$extras}
     *
     * @return array
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * {@see \Qiwi\Entity\Bill::$extras}
     *
     * @param  array               $extras
     * @return \Qiwi\Entities\Bill
     */
    public function setExtras(array $extras)
    {
        array_walk($extras, function ($value) {
            $this->preValidate('#^.{0,500}$#u', $value);
        });

        $this->extras = $extras;

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
            'user'       => $this->getUser(),
            'amount'     => $this->getAmount(),
            'ccy'        => $this->getCurrency(),
            'comment'    => $this->getComment(),
            'lifetime'   => $this->getLifetime() ? $this->getLifetime()->format('c') : null,
            'account'    => $this->getAccount(),
            'pay_source' => $this->getPaySource(),
            'prv_name'   => $this->getProviderName(),
        ];

        if (is_array($this->getExtras())) {
            foreach ($this->getExtras() as $key => $value) {
                $result = array_merge($result, ['extras[' . $key . ']' => $value]);
            }
        }

        $result = array_filter($result);

        $this->postValidate($result);

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @param  array               $input
     * @return \Qiwi\Entities\Bill
     */
    public static function fromArray(array $input)
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
            $entity->setLifetime(strval($input['pay_source']));
        }

        if (isset($input['prv_name'])) {
            $entity->setProviderName(strval($input['prv_name']));
        }

        return $entity;
    }
}
