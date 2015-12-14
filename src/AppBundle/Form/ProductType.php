<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'entity.labels.name'])
            ->add('category', 'entity', array('class' => 'AppBundle:Category',
                'property' => 'name',
                'label' => 'category.labels.self',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->select('c')
                        ->from('AppBundle:Category', 'c')
                        ->where('c.deleted = false')
                        ;
                }

            ))
            ->add('price', null, ['label' => 'product.labels.price'])
            ->add('cost', null, ['label' => 'product.labels.cost'])
            ->add('qty', null, ['label' => 'product.labels.qty'])
            ->add('eanCode', null, ['label' => 'product.labels.eanCode', 'required' => false])
            ->add('upcCode', null, ['label' => 'product.labels.upcCode', 'required' => false])
            ->add('deleted', null, ['label' => 'category.labels.deleted'])
            ->add('deleted', null, ['label' => 'category.labels.deleted'])
            ->add('image', "file", [ 'data_class' => null , 'required' => false])

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
