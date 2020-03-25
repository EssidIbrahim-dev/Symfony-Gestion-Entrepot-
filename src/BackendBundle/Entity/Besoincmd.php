<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Besoincmd
 *
 * @ORM\Table(name="besoincmd")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\BesoincmdRepository")
 */
class Besoincmd
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
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumn(name="commande_id", referencedColumnName="id")
     * */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity="Besoin")
     * @ORM\JoinColumn(name="besoin_id", referencedColumnName="id")
     * */
    private $besoin;


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
     * Set besoin
     *
     * @param string $besoin
     *
     * @return Besoin
     */
    public function setBesoin($besoin)
    {
        $this->besoin = $besoin;

        return $this;
    }

    /**
     * Get Besoin
     *
     * @return string
     */
    public function getBesoin()
    {
        return $this->besoin;
    }
    /**
     * Set commande
     *
     * @param string $commande
     *
     * @return Commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return string
     */
    public function getCommande()
    {
        return $this->commande;
    }


}

