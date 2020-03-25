<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Besoin
 *
 * @ORM\Table(name="besoin")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\BesoinRepository")
 */
class Besoin
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
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Entrepot")
     * @ORM\JoinColumn(name="entrepot_id", referencedColumnName="id")
     * */
    private $entrepot;

    /**
     * @var string
     *
     * @ORM\Column(name="echeance", type="string", length=255)
     */
    private $echeance;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255)
     */
    private $statut;


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
     * Set reference
     *
     * @param string $reference
     *
     * @return Besoin
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Besoin
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set entrepot
     *
     * @param string $entrepot
     *
     * @return Besoin
     */
    public function setEntrepot($entrepot)
    {
        $this->entrepot = $entrepot;

        return $this;
    }
    /**
     * Get entrepot
     *
     * @return Entrepot
     */
    public function getEntrepot()
    {
        return $this->entrepot;
    }

    /**
     * Set echeance
     *
     * @param string $echeance
     *
     * @return Besoin
     */
    public function setEcheance($echeance)
    {
        $this->echeance = $echeance;

        return $this;
    }

    /**
     * Get echeance
     *
     * @return string
     */
    public function getEcheance()
    {
        return $this->echeance;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Besoin
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }
}

