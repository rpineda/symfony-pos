<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Entity\Sale;

/**
 * Item
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ItemRepository")
 *
 */
class Item
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
     * @ORM\ManyToOne(targetEntity="Product", cascade="persist")
     * @ORM\JoinColumn(name="product", referencedColumnName="id")
     * */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Operation", inversedBy="items")
     *
     * */
    private $operation;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", nullable=true)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="float")
     */
    private $cost;

    /**
     * @var float
     *
     * @ORM\Column(name="qty", type="float")
     */
    private $qty;

    /**
     * @var float
     *
     * @ORM\Column(name="subtotal", type="float")
     */
    private $subtotal;

    /**
    *@Assert\Callback
    */

    public function validate(ExecutionContextInterface $context) {

        if ( $this->getProduct() === null ) {

            $context->buildViolation('Select a product')
                ->atPath('product')
                ->addViolation();
            return;
        }
        if ( $this->getOperation() instanceof Sale && $this->getProduct()->getQty() <= 0 ) {

            $context->buildViolation('Stock is empty')
                ->atPath('qty')
                ->addViolation();

            return;
        }
        //fixme update fails when product qty is 0
        if ( $this->getOperation() instanceof Sale && ($this->getProduct()->getQty() - $this->getQty()) < 0 ) {

            $context->buildViolation('No enough stock')
                ->atPath('qty')
                ->addViolation();

            return;
        }

    }

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
     * Set price
     *
     * @param float $price
     *
     * @return Item
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
     * @return Item
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
     * Set qty
     *
     * @param float $qty
     *
     * @return Item
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
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Item
     */
    public function setProduct(\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set operation
     *
     * @param \AppBundle\Entity\Operation $operation
     *
     * @return Item
     */
    public function setOperation(\AppBundle\Entity\Operation $operation = null)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return \AppBundle\Entity\Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set subtotal
     *
     * @param float $subtotal
     *
     * @return Item
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Get subtotal
     *
     * @return float
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }



}
