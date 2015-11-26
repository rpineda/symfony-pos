<?php

/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 26/11/15
 * Time: 11:28
 */

use AppBundle\Entity\Item;
use AppBundle\Entity\Product;
use AppBundle\Utility\SaleItemManager;

class SaleItemManagerTest extends PHPUnit_Framework_TestCase
{
    public function setUp(){

    }
    public function testNewQty(){
        $product = new Product();
        $product->setQty(10);

        $item = new Item();
        $item->setQty(4);
        $item->setProduct($product);

        SaleItemManager::newQty($item);

        $this->assertEquals(6, $item->getProduct()->getQty(), "Unexpected value for qty in product for newQty method ");
    }

    public function testUpdateQtyPlus(){
        $product = new Product();
        $product->setQty(6);

        $item = new Item();
        $item->setQty(4);
        $item->setProduct($product);

        $changes = [4,2];

        SaleItemManager::updateQty($item, $changes);

        $this->assertEquals(8, $item->getProduct()->getQty(), "Unexpected value for qty in product for updateQtyPlus method ");


    }
    public function testUpdateQtyEq(){
        $product = new Product();
        $product->setQty(6);

        $item = new Item();
        $item->setQty(4);
        $item->setProduct($product);

        $changes = [4,4];

        SaleItemManager::updateQty($item, $changes);

        $this->assertEquals(6, $item->getProduct()->getQty(), "Unexpected value for qty in product for updateQtyEq method ");


    }
    public function testUpdateQtyLess(){
        $product = new Product();
        $product->setQty(6);

        $item = new Item();
        $item->setQty(4);
        $item->setProduct($product);

        $changes = [4,6];

        SaleItemManager::updateQty($item, $changes);

        $this->assertEquals(4, $item->getProduct()->getQty(), "Unexpected value for qty in product for updateQtyLess method ");


    }
    public function testDeleteQty(){
        $product = new Product();
        $product->setQty(6);

        $item = new Item();
        $item->setQty(4);
        $item->setProduct($product);

        SaleItemManager::deleteQty($item);

        $this->assertEquals(10, $item->getProduct()->getQty(), "Unexpected value for qty in product for deleteQty method ");


    }
}
