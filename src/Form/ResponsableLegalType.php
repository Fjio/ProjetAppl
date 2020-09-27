<?php

namespace App\Form;

use App\Entity\ResponsableLegal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsableLegalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qualite',QualiteResponsableLegalType::class,array('label'=>false))
            ->add('idResponsable',PersonneType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ResponsableLegal::class,
        ]);
    }
}
