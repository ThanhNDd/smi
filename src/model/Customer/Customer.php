<?php
class Customer {

    private $id;
    private $name;
    private $phone;
    private $email;
    private $address;
    private $village_id;
    private $district_id;
    private $city_id;
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
        return $this->name;
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
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of village_id
     */ 
    public function getVillage_id()
    {
        return $this->village_id;
    }

    /**
     * Set the value of village_id
     *
     * @return  self
     */ 
    public function setVillage_id($village_id)
    {
        $this->village_id = $village_id;

        return $this;
    }

    /**
     * Get the value of district_id
     */ 
    public function getDistrict_id()
    {
        return $this->district_id;
    }

    /**
     * Set the value of district_id
     *
     * @return  self
     */ 
    public function setDistrict_id($district_id)
    {
        $this->district_id = $district_id;

        return $this;
    }

    /**
     * Get the value of city_id
     */ 
    public function getCity_id()
    {
        return $this->city_id;
    }

    /**
     * Set the value of city_id
     *
     * @return  self
     */ 
    public function setCity_id($city_id)
    {
        $this->city_id = $city_id;

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
}
