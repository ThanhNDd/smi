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

    /**
     * OrderDetail constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId($product_id): void
    {
        $this->product_id = $product_id;
    }

    /**
     * @return mixed
     */
    public function getVariantId()
    {
        return $this->variant_id;
    }

    /**
     * @param mixed $variant_id
     */
    public function setVariantId($variant_id): void
    {
        $this->variant_id = $variant_id;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getReduce()
    {
        return $this->reduce;
    }

    /**
     * @param mixed $reduce
     */
    public function setReduce($reduce): void
    {
        $this->reduce = $reduce;
    }

    /**
     * @return mixed
     */
    public function getReducePercent()
    {
        return $this->reduce_percent;
    }

    /**
     * @param mixed $reduce_percent
     */
    public function setReducePercent($reduce_percent): void
    {
        $this->reduce_percent = $reduce_percent;
    }


}