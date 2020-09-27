<?php

namespace App\Form;

use App\Entity\NotesMatiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotesMatiereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('noteMinClasse',NumberType::class,array('label'=>false,'required'=>false))
            ->add('noteMaxClasse',NumberType::class,array('label'=>false,'required'=>false))
            ->add('noteMoyClasse',NumberType::class,array('label'=>false,'required'=>false))
            ->add('noteEleve',NumberType::class,array('label'=>false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NotesMatiere::class,
        ]);
    }
}
