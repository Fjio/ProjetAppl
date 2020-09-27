<?php

namespace App\Form;

use App\Entity\AnneeScolaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnneeScolaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('annee',IntegerType::class, [
                'disabled'=>true,
            ])
            ->add('classe',TextType::class)
            ->add('specialite',ChoiceType::class, [
                'choices'=> [
                    'sciences'=>'sciences',
                    'litterature'=>'litterature',
                    'economie'=>'economie',
                    'autre'=>null,
                ]
            ])
            ->add('etablissement',TextType::class)
            ->add('numeroRue',TextType::class) //attention au 23bis
            ->add('nomRue',TextType::class)
            ->add('ville',TextType::class)
            ->add('codePostal',IntegerType::class)
            ->add('pays',CountryType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnneeScolaire::class,
        ]);
    }
}
