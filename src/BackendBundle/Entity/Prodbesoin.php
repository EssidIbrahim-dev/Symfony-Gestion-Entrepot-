<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prodbesoin
 *
 * @ORM\Table(name="prodbesoin")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\ProdbesoinRepository")
 */
class Prodbesoin
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
     * @var float
     *
     * @ORM\Column(name="qte", type="float")
     */
    private $qte;

    /**
     * @var string
     *
     * @ORM\Column(name="unite", type="string", length=255)
     */
    private $unite;

    /**
     * @ORM\ManyToOne(targetEntity="Besoin")
     * @ORM\JoinColumn(name="besoin_id", referencedColumnName="id")
     * */
    private $besoin;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id_product")
     * */
    private $product;


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
     * Set qte
     *
     * @param float $qte
     *
     * @return Prodbesoin
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return float
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * Set unite
     *
     * @param string $unite
     *
     * @return Prodbesoin
     */
    public function setUnite($unite)
    {
        $this->unite = $unite;

        return $this;
    }

    /**
     * Get unite
     *
     * @return string
     */
    public function getUnite()
    {
        return $this->unite;
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
     * Set product
     *
     * @param string $product
     *
     * @return Product
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }
}

