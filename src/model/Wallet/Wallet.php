<?php


class Wallet
{
    private $Id;
    private $customer_id;
    private $order_id;
    private $saved;
    private $used;
    private $repay;
    private $remain;
    private $order_deleted;
    private $created_at;
    private $updated_at;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setId($Id): void
    {
        $this->Id = $Id;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param mixed $customer_id
     */
    public function setCustomerId($customer_id): void
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     */
    public function setOrderId($order_id): void
    {
        $this->order_id = $order_id;
    }

    /**
     * @return mixed
     */
    public function getSaved()
    {
        return $this->saved;
    }

    /**
     * @param mixed $saved
     */
    public function setSaved($saved): void
    {
        $this->saved = $saved;
    }

    /**
     * @return mixed
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * @param mixed $used
     */
    public function setUsed($used): void
    {
        $this->used = $used;
    }

    /**
     * @return mixed
     */
    public function getRepay()
    {
        return $this->repay;
    }

    /**
     * @param mixed $repay
     */
    public function setRepay($repay): void
    {
        $this->repay = $repay;
    }

    /**
     * @return mixed
     */
    public function getRemain()
    {
        return $this->remain;
    }

    /**
     * @param mixed $remain
     */
    public function setRemain($remain): void
    {
        $this->remain = $remain;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getOrderDeleted()
    {
        return $this->order_deleted;
    }

    /**
     * @param mixed $order_deleted
     */
    public function setOrderDeleted($order_deleted): void
    {
        $this->order_deleted = $order_deleted;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }

}