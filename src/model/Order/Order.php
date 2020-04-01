<?php

class Order {
    private $id;
    private $total_reduce;
    private $total_reduce_percent;
    private $discount;
    private $total_amount;
    private $total_checkout;
    private $customer_payment;
    private $payment_type;
    private $repay;
    private $customer_id;
    private $type;
    private $bill_of_lading_no;
    private $shipping_fee;
    private $shipping;
    private $shipping_unit;
    private $status;
    private $deleted;
    private $order_date;
    private $voucher_code;
    private $voucher_value;
    private $order_refer;
    private $payment_exchange_type;
    private $source;
    private $created_date;
    private $updated_date;

    /**
     * Order constructor.
     */
    public function __construct()
    {
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

   /**
     * Get the value of total_reduce
     */ 
    public function getTotal_reduce()
    {
        return $this->total_reduce;
    }

    /**
     * Set the value of total_reduce
     *
     * @return  self
     */ 
    public function setTotal_reduce($total_reduce)
    {
        $this->total_reduce = $total_reduce;

        return $this;
    }

    /**
     * Get the value of total_reduce_percent
     */ 
    public function getTotal_reduce_percent()
    {
        return $this->total_reduce_percent;
    }

    /**
     * Set the value of total_reduce_percent
     *
     * @return  self
     */ 
    public function setTotal_reduce_percent($total_reduce_percent)
    {
        $this->total_reduce_percent = $total_reduce_percent;

        return $this;
    }

    /**
     * Get the value of discount
     */ 
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set the value of discount
     *
     * @return  self
     */ 
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get the value of total_amount
     */ 
    public function getTotal_amount()
    {
        return $this->total_amount;
    }

    /**
     * Set the value of total_amount
     *
     * @return  self
     */ 
    public function setTotal_amount($total_amount)
    {
        $this->total_amount = $total_amount;

        return $this;
    }

    /**
     * Get the value of total_checkout
     */ 
    public function getTotal_checkout()
    {
        return $this->total_checkout;
    }

    /**
     * Set the value of total_checkout
     *
     * @return  self
     */ 
    public function setTotal_checkout($total_checkout)
    {
        $this->total_checkout = $total_checkout;

        return $this;
    }

    /**
     * Get the value of customer_payment
     */ 
    public function getCustomer_payment()
    {
        return $this->customer_payment;
    }

    /**
     * Set the value of customer_payment
     *
     * @return  self
     */ 
    public function setCustomer_payment($customer_payment)
    {
        $this->customer_payment = $customer_payment;

        return $this;
    }
    /**
     * Get the value of customer_payment
     */ 
    public function getPayment_type()
    {
        return $this->payment_type;
    }

    /**
     * Set the value of Payment_type
     *
     * @return  self
     */ 
    public function setPayment_type($payment_type)
    {
        $this->payment_type = $payment_type;

        return $this;
    }
    /**
     * Get the value of repay
     */ 
    public function getRepay()
    {
        return $this->repay;
    }

    /**
     * Set the value of repay
     *
     * @return  self
     */ 
    public function setRepay($repay)
    {
        $this->repay = $repay;

        return $this;
    }

    /**
     * Get the value of customer_id
     */ 
    public function getCustomer_id()
    {
        return $this->customer_id;
    }

    /**
     * Set the value of customer_id
     *
     * @return  self
     */ 
    public function setCustomer_id($customer_id)
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    /**
     * Get the value of created_date
     */ 
    public function getCreated_date()
    {
        return $this->created_date;
    }

    /**
     * Set the value of created_date
     *
     * @return  self
     */ 
    public function setCreated_date($created_date)
    {
        $this->created_date = $created_date;

        return $this;
    }

    /**
     * Get the value of updated_date
     */ 
    public function getUpdated_date()
    {
        return $this->updated_date;
    }

    /**
     * Set the value of updated_date
     *
     * @return  self
     */ 
    public function setUpdated_date($updated_date)
    {
        $this->updated_date = $updated_date;

        return $this;
    }

    /**
     * Get the value of type
     * 0: shop
     * 1: online
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of bill_of_lading_no
     */ 
    public function getBill_of_lading_no()
    {
        return $this->bill_of_lading_no;
    }

    /**
     * Set the value of bill_of_lading_no
     *
     * @return  self
     */ 
    public function setBill_of_lading_no($bill_of_lading_no)
    {
        $this->bill_of_lading_no = $bill_of_lading_no;

        return $this;
    }

    /**
     * Get the value of shipping
     */ 
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Set the value of shipping
     *
     * @return  self
     */ 
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * Get the value of shipping_unit
     */ 
    public function getShipping_unit()
    {
        return $this->shipping_unit;
    }

    /**
     * Set the value of shipping_unit
     *
     * @return  self
     */ 
    public function setShipping_unit($shipping_unit)
    {
        $this->shipping_unit = $shipping_unit;

        return $this;
    }

    /**
     * Get the value of shipping_fee
     */ 
    public function getShipping_fee()
    {
        if(empty($this->shipping_fee))
        {
            return 0;
        } else {
            return $this->shipping_fee;
        }
    }

    /**
     * Set the value of shipping_fee
     *
     * @return  self
     */ 
    public function setShipping_fee($shipping_fee)
    {
        $this->shipping_fee = $shipping_fee;

        return $this;
    }

    /**
     * Get the value of status
     * 0: pending
     * 1: processing
     * 2: on-hold
     * 3: completed
     * 4: cancelled
     * 5: failed
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of deleted
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
    /**
     * 0: none delete
     * 1: deleted
     */ 
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set the value of deleted
     *
     * @return  self
     */ 
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }
    /**
     * Get the value of order_date
     */ 
    public function getOrder_date()
    {
        return $this->order_date;
    }

    /**
     * Set the value of order_date
     *
     * @return  self
     */ 
    public function setOrder_date($order_date)
    {
        $this->order_date = $order_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVoucherCode()
    {
        return $this->voucher_code;
    }

    /**
     * @param mixed $voucher_code
     */
    public function setVoucherCode($voucher_code)
    {
        $this->voucher_code = $voucher_code;
    }

    /**
     * @return mixed
     */
    public function getVoucherValue()
    {
        return $this->voucher_value;
    }

    /**
     * @param mixed $voucher_code
     */
    public function setVoucherValue($voucher_value)
    {
        $this->voucher_value = $voucher_value;
    }

    /**
     * @return mixed
     */
    public function getOrderRefer()
    {
        return $this->order_refer;
    }

    /**
     * @param mixed $order_refer
     */
    public function setOrderRefer($order_refer): void
    {
        $this->order_refer = $order_refer;
    }

    /**
     * @return mixed
     */
    public function getPaymentExchangeType()
    {
        return $this->payment_exchange_type;
    }

    /**
     * @param mixed $payment_exchange_type
     */
    public function setPaymentExchangeType($payment_exchange_type): void
    {
        $this->payment_exchange_type = $payment_exchange_type;
    }

  /**
   * @return mixed
   */
  public function getSource()
  {
    return $this->source;
  }

  /**
   * @param mixed $source
   */
  public function setSource($source): void
  {
    $this->source = $source;
  }

}
