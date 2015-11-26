<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 25/11/15
 * Time: 23:00
 */

namespace AppBundle\Listener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use AppBundle\Entity\Sale;
use AppBundle\Entity\Purchase;
use AppBundle\Entity\Item;
use AppBundle\Utility\SaleItemManager;
use AppBundle\Utility\PurchaseItemManager;


class ItemListener
{
    public function onFlush(OnFlushEventArgs $eventArgs){
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if($entity instanceof Item && $entity->getOperation() instanceof Sale ) {

                $product = $entity->getProduct();
                $cost = $product->getCost();
                $entity->setCost($cost);

                $price = $entity->getPrice();
                $product->setPrice($price);

                SaleItemManager::newQty($entity);

                $meta_product = $em->getClassMetadata(get_class($product));
                $meta_item = $em->getClassMetadata(get_class($entity));
                $uow->recomputeSingleEntityChangeSet($meta_product, $product);
                $uow->recomputeSingleEntityChangeSet($meta_item, $entity);
            }
            if($entity instanceof Item && $entity->getOperation() instanceof Purchase ) {


                $product = $entity->getProduct();
                $cost = $entity->getCost();
                $product->setCost($cost);

                PurchaseItemManager::newQty($entity);

                $meta_product = $em->getClassMetadata(get_class($product));
                $meta_item = $em->getClassMetadata(get_class($entity));
                $uow->recomputeSingleEntityChangeSet($meta_product, $product);
                $uow->recomputeSingleEntityChangeSet($meta_item, $product);
            }
        }
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if($entity instanceof Item && $entity->getOperation() instanceof Sale ) {

                $changeSet = ($uow->getEntityChangeSet($entity));
                if(!empty($changeSet["qty"])){
                    $changes = [ $changeSet["qty"][0], $changeSet["qty"][1] ];

                    SaleItemManager::updateQty($entity, $changes);
                }
                if(!empty($changeSet["price"])){
                    $new_price = $changeSet["price"][1];

                    $entity->getProduct()->setPrice($new_price);
                }


                $meta = $em->getClassMetadata(get_class($entity->getProduct()));
                $uow->recomputeSingleEntityChangeSet($meta, $entity->getProduct());

            }
            else if($entity instanceof Item && $entity->getOperation() instanceof Purchase ) {

                $changeSet = ($uow->getEntityChangeSet($entity));
                if(!empty($changeSet["qty"])){
                    $changes = [ $changeSet["qty"][0], $changeSet["qty"][1] ];

                    PurchaseItemManager::updateQty($entity, $changes);

                }
                if(!empty($changeSet["cost"])){
                    $new_cost = $changeSet["cost"][1];

                    $entity->getProduct()->setCost($new_cost);
                }


                $meta = $em->getClassMetadata(get_class($entity->getProduct()));
                $uow->recomputeSingleEntityChangeSet($meta, $entity->getProduct());

            }

        }
        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            if($entity instanceof Item && $entity->getOperation() instanceof Sale ) {
                SaleItemManager::deleteQty($entity);

                $meta = $em->getClassMetadata(get_class($entity->getProduct()));
                $uow->recomputeSingleEntityChangeSet($meta, $entity->getProduct());
            }
             else if($entity instanceof Item && $entity->getOperation() instanceof Purchase ) {
                 PurchaseItemManager::deleteQty($entity);


                $meta = $em->getClassMetadata(get_class($entity->getProduct()));
                $uow->recomputeSingleEntityChangeSet($meta, $entity->getProduct());
            }
        }
    }
}