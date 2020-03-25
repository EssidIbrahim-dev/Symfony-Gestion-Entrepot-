<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProdAchat
 *
 * @ORM\Table(name="prod_achat")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\ProdAchatRepository")
 */
class ProdAchat
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
     * @var int
     *
     * @ORM\Column(name="qte", type="integer")
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id_product")
     * */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Achat")
     * @ORM\JoinColumn(name="achat_id", referencedColumnName="id")
     * */
    private $achat;


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
     * @param integer $qte
     *
     * @return ProdAchat
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return int
     */
    public function getQte()
    {
        return $this->qte;
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
     * Get Besoin
     *
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * Set achat
     *
     * @param string $achat
     *
     * @return Achat
     */
    public function setAchat($achat)
    {
        $this->achat = $achat;

        return $this;
    }

    /**
     * Get achat
     *
     * @return string
     */
    public function getAchat()
    {
        return $this->achat;
    }

}

