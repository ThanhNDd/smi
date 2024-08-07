<?php

class Variations
{
    private $id;
    private $product_id;
    private $size;
    private $color;
    private $quantity;
    private $price;
    private $fee;
    private $costPrice;
    private $retail;
    private $salePrice;
    private $percentSale;
    private $profit;
    private $percent;
    private $sku;
    private $image;
    private $image_type;
    private $weight;
    private $height;
    private $length__;
    private $age;
    private $dimension;
    private $updated_qty;
    private $created_at;
    private $updated_at;

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
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size): void
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
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
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @param mixed $fee
     */
    public function setFee($fee): void
    {
        $this->fee = $fee;
    }

    /**
     * @return mixed
     */
    public function getCostPrice()
    {
        return $this->costPrice;
    }

    /**
     * @param mixed $costPrice
     */
    public function setCostPrice($costPrice): void
    {
        $this->costPrice = $costPrice;
    }

    /**
     * @return mixed
     */
    public function getRetail()
    {
        return $this->retail;
    }

    /**
     * @param mixed $retail
     */
    public function setRetail($retail): void
    {
        $this->retail = $retail;
    }

    /**
     * @return mixed
     */
    public function getSalePrice()
    {
        return $this->salePrice;
    }

    /**
     * @param mixed $salePrice
     */
    public function setSalePrice($salePrice): void
    {
        $this->salePrice = $salePrice;
    }

    /**
     * @return mixed
     */
    public function getPercentSale()
    {
        return $this->percentSale;
    }

    /**
     * @param mixed $percentSale
     */
    public function setPercentSale($percentSale): void
    {
        $this->percentSale = $percentSale;
    }

    /**
     * @return mixed
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * @param mixed $profit
     */
    public function setProfit($profit): void
    {
        $this->profit = $profit;
    }

    

    /**
     * @return mixed
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * @param mixed $percent
     */
    public function setPercent($percent): void
    {
        $this->percent = $percent;
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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImageType()
    {
        return $this->image_type;
    }

    /**
     * @param mixed $image_type
     */
    public function setImageType($image_type): void
    {
        $this->image_type = $image_type;
    }
    /**
     * @return mixed
     */
    public function getLength__()
    {
        return $this->length__;
    }

    /**
     * @param mixed $length__
     */
    public function setLength__($length__): void
    {
        $this->length__ = $length__;
    }

     /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

     /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height): void
    {
        $this->height = $height;
    }

     /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age): void
    {
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * @param mixed $age
     */
    public function setDimension($dimension): void
    {
        $this->dimension = $dimension;
    }

    /**
     * @return mixed
     */
    public function getUpdatedQty()
    {
        return $this->updated_qty;
    }

    /**
     * @param mixed $updated_qty
     */
    public function setUpdatedQty($updated_qty): void
    {
        $this->updated_qty = $updated_qty;
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
