<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product' , 'entity', array(
                'class' => 'AppBundle\Entity\Product',
                'property' => 'name',
                'label' => 'item.labels.product'
            ))

            ->add('qty', null, ['label' => 'item.labels.qty'])
            ->add('price', null, ['label' => 'item.labels.price'])
            ->add('cost', null, ['label' => 'item.labels.cost'])

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Item'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_item';
    }
}
