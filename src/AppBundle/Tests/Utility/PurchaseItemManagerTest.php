<?php

/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 26/11/15
 * Time: 12:28
 */

use AppBundle\Entity\Item;
use AppBundle\Entity\Product;
use AppBundle\Utility\PurchaseItemManager;

class PurchaseItemManagerTest extends PHPUnit_Framework_TestCase
{
    public function testNewQty(){
        $product = new Product();
        $product->setQty(6);

        $item = new Item();
        $item->setQty(4);
        $item->setProduct($product);

        PurchaseItemManager::newQty($item);

        $this->assertEquals(10, $item->getProduct()->getQty(), "Unexpected value for qty in product for newQty method ");
    }

    public function testUpdateQtyPlus(){
        $product = new Product();
        $product->setQty(10);

        $item = new Item();
        $item->setQty(4);
        $item->setProduct($product);

        $changes = [4,2];

        PurchaseItemManager::updateQty($item, $changes);

        $this->assertEquals(8, $item->getProduct()->getQty(), "Unexpected value for qty in product for updateQtyPlus method ");


    }
    public function testUpdateQtyEq(){
        $product = new Product();
        $product->setQty(10);

        $item = new Item();
        $item->setQty(4);
        $item->setProduct($product);

        $changes = [4,4];

        PurchaseItemManager::updateQty($item, $changes);

        $this->assertEquals(10, $item->getProduct()->getQty(), "Unexpected value for qty in product for updateQtyEq method ");


    }
    public function testUpdateQtyLess(){
        $product = new Product();
        $product->setQty(10);

        $item = new Item();
        $item->setQty(4);
        $item->setProduct($product);

        $changes = [4,6];

        PurchaseItemManager::updateQty($item, $changes);

        $this->assertEquals(12, $item->getProduct()->getQty(), "Unexpected value for qty in product for updateQtyLess method ");


    }

    public function testDeleteQty(){
        $product = new Product();
        $product->setQty(6);

        $item = new Item();
        $item->setQty(4);
        $item->setProduct($product);

        PurchaseItemManager::deleteQty($item);

        $this->assertEquals(2, $item->getProduct()->getQty(), "Unexpected value for qty in product for deleteQty method ");


    }
}
