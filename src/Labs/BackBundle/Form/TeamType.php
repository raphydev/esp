<?php

namespace Labs\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class TeamType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, array('label' => false, 'attr'  => array('class' => 'form-control')))
            ->add('poste',TextType::class, array('label' => false, 'attr'  => array('class' => 'form-control')))
            ->add('link',TextType::class, array('label' => false, 'attr'  => array('class' => 'form-control')))
            ->add('position',NumberType::class, array('label' => false))
            ->add('types',ChoiceType::class, array(
                'label' => false,
                'choices' => array('Officiel' => 1, 'Speakers' => 0),
            ))
            ->add('imageFile', VichImageType::class,array(
                'label' => false,
                'required' => false,
                'allow_delete' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Labs\BackBundle\Entity\Team'
        ));
    }
}
