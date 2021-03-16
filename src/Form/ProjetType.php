<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('years')
            ->add('nb_of_tracks')
            ->add('sample')
            ->add('linkone')
            ->add('linktwo')
            ->add('linkthree')
            ->add('cover')
            ->add('description')
            ->add('createur', EntityType::class, [
                'class' => User::class,
                'multiple' => false,
                'expanded' => true,
                'choice_label' => 'login'
                ])
            ->add('feat', EntityType::class, [
                'class' => User::class,
                'multiple' => true,
                'expanded' => false,
                'choice_label' => 'login'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
