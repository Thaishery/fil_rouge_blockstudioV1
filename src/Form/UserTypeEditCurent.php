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

class UserTypeEditCurrent extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    { 
        $builder
            ->add('login')
            ->add('email', EmailType::class)
            ->add('firstname')
            ->add('lastname')
            ->add('address')
            ->add('phone')
           
            
            // ->add('avatar',
            // FileType::class, [
            //         'constraints' => [
            //             new File([
            //                 'maxSize' => '1024k',
            //                 'mimeTypes' => [
            //                     'image/jpeg',
            //                     ]
            //             ])
            //         ]
            //     ]
            //  );

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