<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'product.labels.name'])
            ->add('category', 'entity', array('class' => 'AppBundle:Category',
                'property' => 'name',
                'label' => 'product.labels.category'
            ))
            ->add('price', null, ['label' => 'product.labels.price'])
            ->add('cost', null, ['label' => 'product.labels.cost'])
            ->add('qty', null, ['label' => 'product.labels.qty'])
            ->add('deleted', null, ['label' => 'product.labels.deleted'])

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_product';
    }
}
