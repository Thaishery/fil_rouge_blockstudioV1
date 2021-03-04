<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;



 class RegistrationFormType extends AbstractType
 {
    public function buildForm(FormBuilderInterface $builder, array $options)
     {
         $builder
             ->add('lastname', TextType::class, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[A-Z][\p{L}-]*$/',
                        'message' => 'Votre nom est invalide, il ne dois pas comporter de nombres ou d\'espace et commencer par une majuscule.',
                    ]),
                ],
            ])

             ->add('firstname', TextType::class, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[A-Z][\p{L}-]*$/',
                        'message' => 'Votre prénom est invalide, il ne dois pas comporter de nombres ou d\'espace et commencer par une majuscule.',
                    ]),
                ],
            ])

             ->add('login', TextType::class,[
                 'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z0-9]*$/',
                        'message' => 'Votre login ne peut comporter que des caractéres alphanumérique.'
                    ])
                 ]
             ])

             ->add('email', RepeatedType::class,[
                'type' => EmailType::class,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^\w*[a-zA-Z0-9-_âêîôûäëïöüéèàçÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙ]*+@\w*[a-zA-Z0-9-_âêîôûäëïöüéèàçÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙ]*+\.\w+$/',
                        'message' => 'Email invalide'
                    ])
                ],
                'invalid_message' => 'The email fields must match.',
                'options' => ['attr' => ['class' => 'email-field']],
                'required' => true,
                'first_options'  => ['label' => 'email'],
                'second_options' => ['label' => 'Veuillez repeter votre email'],
            ])
            
             ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les conditions',
                    ]),
                ],
            ])

            //password whit repeated type: 

             ->add('plainPassword', RepeatedType::class, [
                 'type' => PasswordType::class,
                 'mapped' => false,
                 'constraints' => [

                     new NotBlank([
                         'message' => 'Veuillez entrer un mot de passe.',
                        ]),

                     new Length([
                         'min' => 6,
                         'minMessage' => 'Votre mot de passe doit au minimum contenir {{ limit }} caractères.',
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
                        ]),
                    ],
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Veullez répeter votre mot de passe'],
            ]);
        ;
    }












    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
