<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 *
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Category", cascade="persist")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     * */
    private $category;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="float")
     */
    private $cost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted;

    /**
     * @var float
     *
     * @ORM\Column(name="qty", type="float")
     */
    private $qty;


    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Image(
     *     mimeTypes = {"image/jpeg" , "image/png"}
     * )
     *
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="ean_code", type="string", length=255)
     */
    private $eanCode;

    /**
     * @var string
     *
     * @ORM\Column(name="upc_code", type="string", length=255)
     */
    private $upcCode;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set cost
     *
     * @param float $cost
     *
     * @return Product
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Product
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set qty
     *
     * @param float $qty
     *
     * @return Product
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return float
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Estableciendo fecha de creación y actualización al crear
     *
     * @ORM\PrePersist
     */
    public function onCreate()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Estableciendo fecha de actualización
     *
     * @ORM\PreUpdate
     */
    public function onUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }


    /**
     * Set image
     *
     * @param string $image
     *
     * @return Product
     */


    public function setImage($image )
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set eanCode
     *
     * @param string $eanCode
     *
     * @return Product
     */
    public function setEanCode($eanCode)
    {
        $this->eanCode = $eanCode;

        return $this;
    }

    /**
     * Get eanCode
     *
     * @return string
     */
    public function getEanCode()
    {
        return $this->eanCode;
    }

    /**
     * Set upcCode
     *
     * @param string $upcCode
     *
     * @return Product
     */
    public function setUpcCode($upcCode)
    {
        $this->upcCode = $upcCode;

        return $this;
    }

    /**
     * Get upcCode
     *
     * @return string
     */
    public function getUpcCode()
    {
        return $this->upcCode;
    }

    /**
     *@Assert\Callback
     */

    public function validateEan(ExecutionContextInterface $context) {

        if ( $this->getEanCode() !== null ) {

            $eanCode = $this->getEanCode();

            if( strlen($eanCode) !== 13 ) {
                $context->buildViolation('Not a valid EAN-13 code(length)')
                    ->atPath('eanCode')
                    ->addViolation();
                return;
            }

            $eanCodeRoot = substr($eanCode,0,12);

            $checksum = 0;
            foreach (str_split(strrev($eanCodeRoot)) as $pos => $val) {
                $checksum += $val * (3 - 2 * ($pos % 2));
            }
            $controlDigit = ((10 - ($checksum % 10)) % 10);

            if($eanCode[12] != $controlDigit){
                $context->buildViolation('Not a valid EAN-13 code(checksum)')
                    ->atPath('eanCode')
                    ->addViolation();
                return;
            }


        }


    }
}
