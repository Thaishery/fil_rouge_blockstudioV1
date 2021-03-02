<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints as Assert;
use Webmozart\Assert\Assert as AssertAssert;

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
                    // regex caractére spécial : 
                    new Assert\Regex([
                        'pattern' => '/[^A-Za-z0-9]+/',
                        'message' => 'Vous devez saisir au moins 1 caractére spécial.'
                    ]),
                    //regex Majuscule : 
                    new Assert\Regex([
                        'pattern' => '/[A-Z]+/',
                        'message' => 'Vous devez saisir au moins 1 Majuscule.'
                    ])
                ],
            ])
            ->add('email', EmailType::class,[
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^\S+@\S+\.\S+$/',
                        'message' => 'Email invalide'
                    ])
                ]
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[A-Z][\p{L}-]*$/',
                        'message' => 'Votre prénom est invalide, il ne dois pas comporter de nombres ou d\'espace et commencer par une majuscule.',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[A-Z][\p{L}-]*$/',
                        'message' => 'Votre nom est invalide, il ne dois pas comporter de nombres ou d\'espace et commencer par une majuscule.',
                    ]),
                ],
            ])
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