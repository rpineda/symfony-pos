<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\ItemType;
use Doctrine\ORM\EntityRepository;

class PurchaseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('items', 'collection', array(
                'type' => new ItemType(),
                'allow_add' => true,
                'allow_delete' => true,
                'cascade_validation' => true,
                'by_reference' => false,
                'required' => true,
            ))
            ->add('person', 'entity', array('class' => 'AppBundle:Person',
                'property' => 'name',
                'label' => 'supplier.labels.self',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->select('s')
                        ->from('AppBundle:Supplier', 's')
                        ->where('s.deleted = false')
                        ;
                }))
            ->add('cash', null, ['label' => 'operation.labels.cash'])
            ->add('total', null, ['label' => 'operation.labels.total' , 'attr'=> array('class'=>'total')])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Purchase'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_operation';
    }
}
