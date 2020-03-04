<?php


class Check
{
    private $id;
    private $seq;
    private $status;
    private $total_products;
    private $products_checked;
    private $start_date;
    private $finished_date;
    private $total_money;
    private $money_checked;
    private $created_date;
    private $updated_date;

    /**
     * Fee constructor.
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
    public function getSeq()
    {
        return $this->seq;
    }

    /**
     * @param mixed $seq
     */
    public function setSeq($seq): void
    {
        $this->seq = $seq;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getTotalProducts()
    {
        return $this->total_products;
    }

    /**
     * @param mixed $total_products
     */
    public function setTotalProducts($total_products): void
    {
        $this->total_products = $total_products;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate($start_date): void
    {
        $this->start_date = $start_date;
    }

    /**
     * @return mixed
     */
    public function getFinishedDate()
    {
        return $this->finished_date;
    }

    /**
     * @param mixed $finished_date
     */
    public function setFinishedDate($finished_date): void
    {
        $this->finished_date = $finished_date;
    }

    /**
     * @return mixed
     */
    public function getTotalMoney()
    {
        return $this->total_money;
    }

    /**
     * @param mixed $total_money
     */
    public function setTotalMoney($total_money): void
    {
        $this->total_money = $total_money;
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

    /**
     * @return mixed
     */
    public function getProductsChecked()
    {
        return $this->products_checked;
    }

    /**
     * @param mixed $products_checked
     */
    public function setProductsChecked($products_checked): void
    {
        $this->products_checked = $products_checked;
    }

    /**
     * @return mixed
     */
    public function getMoneyChecked()
    {
        return $this->money_checked;
    }

    /**
     * @param mixed $money_checked
     */
    public function setMoneyChecked($money_checked): void
    {
        $this->money_checked = $money_checked;
    }

}