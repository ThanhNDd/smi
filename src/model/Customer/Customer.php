<?php

class Customer
{

    public $id;
    public $name;
    public $avatar;
    public $phone;
    public $email;
    public $facebook;
    public $link_fb;
    public $birthday;
    public $village_id;
    public $district_id;
    public $city_id;
    public $address;
    public $full_address;
    public $active;
    public $purchased;
    public $source_register;
    public $created_at;
    public $updated_at;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param mixed $facebook
     */
    public function setFacebook($facebook): void
    {
        $this->facebook = $facebook;
    }

    /**
     * @return mixed
     */
    public function getLinkFb()
    {
        return $this->link_fb;
    }

    /**
     * @param mixed $link_fb
     */
    public function setLinkFb($link_fb): void
    {
        $this->link_fb = $link_fb;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getVillageId()
    {
        return $this->village_id;
    }

    /**
     * @param mixed $village_id
     */
    public function setVillageId($village_id): void
    {
        $this->village_id = $village_id;
    }

    /**
     * @return mixed
     */
    public function getDistrictId()
    {
        return $this->district_id;
    }

    /**
     * @param mixed $district_id
     */
    public function setDistrictId($district_id): void
    {
        $this->district_id = $district_id;
    }

    /**
     * @return mixed
     */
    public function getCityId()
    {
        return $this->city_id;
    }

    /**
     * @param mixed $city_id
     */
    public function setCityId($city_id): void
    {
        $this->city_id = $city_id;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getFullAddress()
    {
        return $this->full_address;
    }

    /**
     * @param mixed $full_address
     */
    public function setFullAddress($full_address): void
    {
        $this->full_address = $full_address;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getPurchased()
    {
        return $this->purchased;
    }

    /**
     * @param mixed $purchased
     */
    public function setPurchased($purchased): void
    {
        $this->purchased = $purchased;
    }

    /**
     * @return mixed
     */
    public function getSourceRegister()
    {
        return $this->source_register;
    }

    /**
     * @param mixed $source_register
     */
    public function setSourceRegister($source_register): void
    {
        $this->source_register = $source_register;
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
