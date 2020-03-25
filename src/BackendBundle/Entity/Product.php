<?php

namespace BackendBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_product",type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255)
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="product_type", type="string", length=255)
     */
    private $productType;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=255)
     */
    private $marque;

    /**
     * @var float
     *
     * @ORM\Column(name="priceHT", type="float")
     */
    private $priceHT;

    /**
     * @var float
     *
     * @ORM\Column(name="priceTTC", type="float")
     */
    private $priceTTC;

    /**
     * @var float
     *
     * @ORM\Column(name="TVA", type="float")
     */
    private $tVA;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="float")
     */
    private $weight;
    /**
     * @ORM\Column(name="photo", type="string", length=500)
     * @Assert\File(maxSize="500k", mimeTypes={"image/jpeg", "image/jpg", "image/png"})
     */
    private $photo;

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
     * Set productName
     *
     * @param string $productName
     *
     * @return Product
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set productType
     *
     * @param string $productType
     *
     * @return Product
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;

        return $this;
    }

    /**
     * Get productType
     *
     * @return string
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Product
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
     * Set marque
     *
     * @param string $marque
     *
     * @return Product
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set priceHT
     *
     * @param float $priceHT
     *
     * @return Product
     */
    public function setPriceHT($priceHT)
    {
        $this->priceHT = $priceHT;

        return $this;
    }

    /**
     * Get priceHT
     *
     * @return float
     */
    public function getPriceHT()
    {
        return $this->priceHT;
    }

    /**
     * Set priceTTC
     *
     * @param string $priceTTC
     *
     * @return Product
     */
    public function setPriceTTC($priceTTC)
    {
        $this->priceTTC = $priceTTC;

        return $this;
    }

    /**
     * Get priceTTC
     *
     * @return string
     */
    public function getPriceTTC()
    {
        return $this->priceTTC;
    }

    /**
     * Set tVA
     *
     * @param float $tVA
     *
     * @return Product
     */
    public function setTVA($tVA)
    {
        $this->tVA = $tVA;

        return $this;
    }

    /**
     * Get tVA
     *
     * @return float
     */
    public function getTVA()
    {
        return $this->tVA;
    }

    /**
     * Set weight
     *
     * @param float $weight
     *
     * @return Product
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }
    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

}

