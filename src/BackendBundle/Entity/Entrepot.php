<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entrepot
 *
 * @ORM\Table(name="entrepot")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\EntrepotRepository")
 */
class Entrepot
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrRangs", type="integer")
     */
    private $nbrRangs;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_bis", type="string", length=255)
     */
    private $phoneBis;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Entrepot
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set nbrRangs
     *
     * @param integer $nbrRangs
     *
     * @return Entrepot
     */
    public function setNbrRangs($nbrRangs)
    {
        $this->nbrRangs = $nbrRangs;

        return $this;
    }

    /**
     * Get nbrRangs
     *
     * @return int
     */
    public function getNbrRangs()
    {
        return $this->nbrRangs;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Entrepot
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set phoneBis
     *
     * @param string $phoneBis
     *
     * @return Entrepot
     */
    public function setPhoneBis($phoneBis)
    {
        $this->phoneBis = $phoneBis;

        return $this;
    }

    /**
     * Get phoneBis
     *
     * @return string
     */
    public function getPhoneBis()
    {
        return $this->phoneBis;
    }
}

