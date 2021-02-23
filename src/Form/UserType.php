<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login')
            ->add('roles', ChoiceType::class,[
                'choices' => [
                    'administrateur' => 'ROLE_ADMIN',
                    'artistes' => 'ROLE_USER',
                    'modérateur' => 'ROLE_MODERATEUR',
                ],
                'multiple' => true,
                'expanded' => true
            ])
             ->add('plainPassword', PasswordType::class, [
                 // instead of being set onto the object directly,
                 // this is read and encoded in the controller
                 'mapped' => false,
                 'constraints' => [
                     new NotBlank([
                         'message' => 'Please enter a password',
                     ]),
                     new Length([
                         'min' => 6,
                         'minMessage' => 'Your password should be at least {{ limit }} characters',
                         // max length allowed by Symfony for security reasons
                         'max' => 4096,
                     ]),
                 ],
             ])
            ->add('email', EmailType::class)
            ->add('firstname')
            ->add('lastname')
            ->add('address')
            ->add('phone')
            //->add('avatar')
            //->add('UserProjet')
            //->add('UserPlateforme')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}