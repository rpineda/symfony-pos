<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\ItemType;
use Doctrine\ORM\EntityRepository;

class SaleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('total')
            ->add('cash', null, ['label' => 'sale.labels.cash'])
            ->add('person', 'entity', array('class' => 'AppBundle:Person',
                'property' => 'name',
                'label' => 'sale.labels.person',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->select('c')
                        ->from('AppBundle:Client', 'c');
                }))
            ->add('items', 'collection', array(
                'type' => new ItemType(),
                'allow_add' => true,
                'allow_delete' => true,
                'cascade_validation' => true,
                'by_reference' => false,
                'required' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Sale'
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