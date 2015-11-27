<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


/**
 * Description of SearchReportType
 *
 * @author felipe
 */
class SearchReportType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder


            ->add('initDate', 'datetime',array(
                'attr'=> array( "class"=> "init_date" ),
                'mapped' => false,
                "years" => range(2015, date("Y")),
                'label' => 'search.labels.initDate',

            ))
            ->add('endDate', 'datetime', array(
                'attr'=> array( "class"=> "end_date" ),
                'mapped' => false,
                "years" => range(2015, date("Y")),
                'data' => new \DateTime(),
                'label' => 'search.labels.endDate',

            ))

            ->add('person', 'entity', array('class' => 'AppBundle:Person',
                'property' => 'name',
                'label' => 'client.labels.self',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->select('c')
                        ->from('AppBundle:Client', 'c')
                        ->where('c.deleted = false')
                        ;
                }))
            ->add('group', 'choice', array(
                'attr'=> array( "class"=> "group" ),
                'choices'  => array('1' => 'product', '2' => 'category', '3' => 'client'),
                'mapped' => false,
                'label' => 'search.labels.group',

            ))
            ->add('cash', 'checkbox', array(
                'required' => false,
                'attr'=> array('mapped' => false, "class" => "credito"),
                'label' => 'operation.labels.cash',

            ))
                ->add('submit', 'submit', array(
                    'attr'=> array( "class"=> "btn btn-default" ),
                    'label' => 'Search'
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Sale',
            'cascade_validation' => true,
            'method' => "GET",
        ));
    }

    public function getName() {
        return 'appBundle_search_operation';
    }

}
