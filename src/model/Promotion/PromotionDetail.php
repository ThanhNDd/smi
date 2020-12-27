<?php


class PromotionDetail
{
    private $id;
    private $promotion_id;
    private $product_id;
    private $variant_id;
    private $sku;
    private $retail_price;
    private $sale_price;
    private $percent;
    private $created_date;
    private $updated_date;

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
    public function getPromotionId()
    {
        return $this->promotion_id;
    }

    /**
     * @param mixed $promotion_id
     */
    public function setPromotionId($promotion_id): void
    {
        $this->promotion_id = $promotion_id;
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
    public function getRetailPrice()
    {
        return $this->retail_price;
    }

    /**
     * @param mixed $retail_price
     */
    public function setRetailPrice($retail_price): void
    {
        $this->retail_price = $retail_price;
    }

    /**
     * @return mixed
     */
    public function getSalePrice()
    {
        return $this->sale_price;
    }

    /**
     * @param mixed $sale_price
     */
    public function setSalePrice($sale_price): void
    {
        $this->sale_price = $sale_price;
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
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * @param mixed $created_date
     */
    public function setCreatedDate($created_date): void
    {
        $this->created_date = $created_date;
    }

    /**
     * @return mixed
     */
    public function getUpdatedDate()
    {
        return $this->updated_date;
    }

    /**
     * @param mixed $updated_date
     */
    public function setUpdatedDate($updated_date): void
    {
        $this->updated_date = $updated_date;
    }

}
