<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ItemSaleType extends AbstractType
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
                'label' => 'product.labels.self',
                'group_by' => 'Category.name' ,
                'placeholder' => 'Select the product',
                 'attr'=> array('class'=>'product'),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('q')
                        ->select('p')
                        ->from('AppBundle:Product', 'p')
                        ->where('p.deleted = false')
                        ;
                }
            ))

            ->add('qty', null, ['label' => 'product.labels.qty', 'attr'=> array('class'=>'qty')])
            ->add('price', null, ['label' => 'product.labels.price', 'attr'=> array('class'=>'price') ])
            ->add('tax', null, ['label' => 'tax.labels.self', 'attr'=> array('class'=>'tax') ])
            ->add('discount', null, ['label' => 'discount.labels.self', 'attr'=> array('class'=>'discount') ])
            ->add('subtotal', null, ['label' => 'item.labels.subtotal', 'attr'=> array('class'=>'subtotal')])


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
