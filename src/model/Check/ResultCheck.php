<?php


class ResultCheck
{
    private $total_qty;
    private $total_money;
    private $check_time;
    private $created_date;
    private $updated_date;

    /**
     * @return mixed
     */
    public function getTotalQty()
    {
        return $this->total_qty;
    }

    /**
     * @param mixed $total_qty
     */
    public function setTotalQty($total_qty): void
    {
        $this->total_qty = $total_qty;
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
    public function getCheckTime()
    {
        return $this->check_time;
    }

    /**
     * @param mixed $check_time
     */
    public function setCheckTime($check_time): void
    {
        $this->check_time = $check_time;
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