<?php
class Product {
    private $id;
    private $name;
    private $image;
    private $link;
    private $price;
    private $fee_transport;
    private $profit;
    private $percent;
    private $retail;
    private $type;
    private $status;
    private $category_id;
    private $created_at;
    private $updated_at;

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
     * Get the value of name
     */ 
    public function getName()
    {
        return "\"".$this->name."\"";    
     
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return "\"".$this->image."\"";    
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of link
     */ 
    public function getLink()
    {
        if(empty($this->link))
        {
            return "NULL";
        } else {
            return "\"".$this->link."\"";    
        }
    }

    /**
     * Set the value of link
     *
     * @return  self
     */ 
    public function setLink($link)
    {
        $this->link = $link;

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
     * Get the value of fee_transport
     */ 
    public function getFee_transport()
    {
        if(empty($this->fee_transport))
        {
            return "NULL";
        } else {
            return "\"".$this->fee_transport."\"";    
        }
    }

    /**
     * Set the value of fee_transport
     *
     * @return  self
     */ 
    public function setFee_transport($fee_transport)
    {
        $this->fee_transport = $fee_transport;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of profit
     */ 
    public function getProfit()
    {
        if(empty($this->profit))
        {
            return "NULL";
        } else {
            return "\"".$this->profit."\"";    
        }
    }

    /**
     * Set the value of profit
     *
     * @return  self
     */ 
    public function setProfit($profit)
    {
        $this->profit = $profit;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        if(empty($this->type))
        {
            return "0";
        } else {
            return $this->type;    
        }
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
     * Get the value of category_id
     */ 
    public function getCategory_id()
    {
        if(empty($this->category_id))
        {
            return "NULL";
        } else {
            return "\"".$this->category_id."\"";    
        }
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }
    /**
     * Get the value of percent
     */ 
    public function getPercent()
    {
        if(empty($this->percent))
        {
            return 0;
        } else {
            return $this->percent;    
        }
    }

    /**
     * Set the value of percent
     *
     * @return  self
     */ 
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }
    /**
     * Get the value of retail
     */ 
    public function getRetail()
    {
        if(empty($this->retail))
        {
            return "NULL";
        } else {
            return $this->retail;    
        }
    }

    /**
     * Set the value of retail
     *
     * @return  self
     */ 
    public function setRetail($retail)
    {
        $this->retail = $retail;

        return $this;
    }
}