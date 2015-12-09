<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 25/11/15
 * Time: 23:00
 */

namespace AppBundle\Listener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use AppBundle\Entity\Product;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductListener
{

    protected $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    public function onFlush(OnFlushEventArgs $eventArgs){
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if($entity instanceof Product  ) {

                $image = $entity->getImage();

                if($image != null){
                    // Generate a unique name for the file before saving it
                    $fileName =  "product_" . $entity->getId() . '.'.$image->guessExtension();

                    // Move the file to the directory where brochures are stored
                    $brochuresDir = $this->container->get('kernel')->getRootDir() . '/../web/images';;
                    $image->move($brochuresDir, $fileName);

                    // Update the 'brochure' property to store the PDF file name
                    // instead of its contents
                    $entity->setImage($fileName);

                    $meta_item = $em->getClassMetadata(get_class($entity));
                    $uow->recomputeSingleEntityChangeSet($meta_item, $entity);
                }

            }

        }
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if($entity instanceof Product  ) {

                $changeSet = ($uow->getEntityChangeSet($entity));
                if(!empty($changeSet["image"])){

                    $old = $changeSet["image"][0];
                    $new = $changeSet["image"][1];


                    $image = $entity->getImage();

                    if($new != null){
                        // Generate a unique name for the file before saving it
                        $fileName =  "product_" . $entity->getId() . '.'.$image->guessExtension();

                        // Move the file to the directory where brochures are stored
                        $brochuresDir =  $this->container->get('kernel')->getRootDir(). '/../web/images';;
                        $image->move($brochuresDir, $fileName);

                        // Update the 'brochure' property to store the PDF file name
                        // instead of its contents
                        $entity->setImage($fileName);

                    } else{
                        $entity->setImage($old);
                    }
                    $meta_item = $em->getClassMetadata(get_class($entity));
                    $uow->recomputeSingleEntityChangeSet($meta_item, $entity);

                }
            }


        }
        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            if($entity instanceof Product  ) {

            }

        }
    }
}