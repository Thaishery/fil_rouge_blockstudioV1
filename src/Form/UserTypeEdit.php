<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserTypeEdit extends AbstractType
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
             ->add('email', EmailType::class)
             ->add('firstname') 
             ->add('lastname')
             ->add('address')
             ->add('phone')

            //  ->add('avatar')
             ->add('avatar',
                 FileType::class, [
                     'constraints' => [
                            new File([
                                'maxSize' => '1024k',
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/bmp',
                                    'image/gif',
                                    'image/png',
                                    'image/svg+xml',
                                    'image/tiff',
                                    'image/webp',
                                    ]
                            ])
                        ],
                        'required'   => false,
                        'mapped' => false,
                    ]
                 )

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