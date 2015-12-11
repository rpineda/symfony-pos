<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BusinessType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,['label' => 'entity.labels.name'])
            ->add('city', null,['label' => 'data.labels.city'])
            ->add('street', null,['label' => 'data.labels.street'])
            ->add('phone', null,['label' => 'data.labels.phone'])
            ->add('email', null,['label' => 'data.labels.phone'])
            ->add('initDate', null,['label' => 'data.labels.initDate'])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Business'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_business';
    }
}
