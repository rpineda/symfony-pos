<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 26/11/15
 * Time: 11:21
 */

namespace AppBundle\Utility;

use AppBundle\Entity\Item;

class SaleItemManager
{
    public static function newQty(Item $item){
        $product = $item->getProduct();
        $cost = $product->getCost();
        $item->setCost($cost);

        $qty = $product->getQty();
        $qty_out= $item->getQty();

        $product->setQty($qty-$qty_out);
    }

    public static function updateQty(Item $item, $changes){

        $product = $item->getProduct();
        $qty = $product->getQty();

        $product->setQty($qty + $changes[0]);

        $qty = $product->getQty();

        $product->setQty($qty - $changes[1]);

    }

    public static function deleteQty(Item $item){
        $product = $item->getProduct();

        $qty = $product->getQty();
        $qty_out= $item->getQty();

        $product->setQty($qty + $qty_out);
    }

}