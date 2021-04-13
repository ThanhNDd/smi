<?php


class OrderLogs
{
    private $id;
    private $order_id;
    private $action;
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
  public function getAction()
  {
    return $this->action;
  }

  /**
   * @param mixed $action
   */
  public function setAction($action): void
  {
    $this->action = $action;
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
