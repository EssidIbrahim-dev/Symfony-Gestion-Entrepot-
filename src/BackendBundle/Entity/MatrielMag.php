<?php

namespace BackendBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\MatrielMagRepository")
 * @ORM\Table(name="MatrielMag")
 * @ORM\HasLifecycleCallbacks()
 */
class MatrielMag
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $IDM;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(name="photo", type="string", length=500)
     * @Assert\File(maxSize="500k", mimeTypes={"image/jpeg", "image/jpg", "image/png"})
     */
    private $photo;

    /**
     * @return mixed
     */
    /**
     * Get IDM
     *
     * @return int
     */
    public function getIDM()
    {
        return $this->IDM;
    }
    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $referenec
     */
    public function setDescription($reference)
    {
        $this->reference = $reference;
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


    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return MatrielMag
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }
}
