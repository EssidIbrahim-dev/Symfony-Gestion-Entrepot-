<?php
// src/AppBundle/Entity/User.php

namespace BackendBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $IDU;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $surname;
    /**
     * @ORM\Column(type="integer", length=8)
     */
    protected $num_tel;


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
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }
    /**
     * @return mixed
     */
    public function getNumTel()
    {
        return $this->surname;
    }

    /**
     * @param mixed $num_tel
     */
    public function setNumTel($num_tel)
    {
        $this->num_tel = $num_tel;
    }

    /**
     * Get iDU
     *
     * @return integer
     */
    public function getIDU()
    {
        return $this->IDU;
    }
}
