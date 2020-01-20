<?php
class OrderDetail {
    private $id;
    private $order_id;
    private $product_id;
    private $variant_id;
    private $sku;
    private $price;
    private $quantity;
    private $reduce;
    private $reduce_percent;
    private $product_name;
    // 0: add new, 1: exchange, 2: new product of exchange order
    private $type;

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
     * Get the value of order_id
     */
    public function getOrder_id()
    {
        return $this->order_id;
    }

    /**
     * Set the value of order_id
     *
     * @return  self
     */
    public function setOrder_id($order_id)
    {
        $this->order_id = $order_id;

        return $this;
    }

    /**
     * Get the value of product_id
     */
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of variant_id
     */
    public function getVariant_id()
    {
        return $this->variant_id;
    }

    /**
     * Set the value of variant_id
     *
     * @return  self
     */
    public function setVariant_id($variant_id)
    {
        $this->variant_id = $variant_id;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of reduce
     */
    public function getReduce()
    {
        return $this->reduce;
    }

    /**
     * Set the value of reduce
     *
     * @return  self
     */
    public function setReduce($reduce)
    {
        $this->reduce = $reduce;

        return $this;
    }

    /**
     * Get the value of reduce_percent
     */
    public function getReduce_percent()
    {
        return $this->reduce_percent;
    }

    /**
     * Set the value of reduce_percent
     *
     * @return  self
     */
    public function setReduce_percent($reduce_percent)
    {
        $this->reduce_percent = $reduce_percent;

        return $this;
    }

    /**
     * Get the value of sku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set the value of sku
     *
     * @return  self
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get the value of product_name
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * Set the value of product_name
     *
     * @return  self
     */
    public function setProductName($product_name)
    {
        $this->product_name = $product_name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

}