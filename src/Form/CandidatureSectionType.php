<?php

namespace App\Form;

use App\Entity\Candidature;
use Symfony\Component\Form\AbstractType;
use App\Repository\SectionRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatureSectionType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sections=$options['sectionsPossibles']; //le tableau est trié alphabétiquement
        $builder
            ->add('nomSection', ChoiceType::class, [
                'choices'=> [
                    'son'=>$sections[2],
                    'image'=>$sections[0],
                    'litteraire'=>$sections[1],
                    ],
                'multiple'=>false,
                'expanded'=>true,
                ]

    )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,

        ]);

        $resolver->setRequired(array(
            'sectionsPossibles'
        ));
    }
}
