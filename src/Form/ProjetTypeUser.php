<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Webmozart\Assert\Assert as AssertAssert;

class ProjetTypeUser extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z0-9äâàéèêëïîöôüûùç$£€µ§@:_-¢ß¥™©®ª×÷±²³µ¿¶·º°¯§…¤¦≠¬ˆ¨‰"]*/',
                        'message' => 'Votre Titre ne peut pas contenir de caractéres spéciaux.'
                    ])
                 ]
            ])
            //->add('years')
            ->add('nb_of_tracks', NumberType::class)
            ->add('sample', 
                FileType::class, [
                    'constraints' => [
                        new File([
                            'maxSize' => '10M',
                            'mimeTypes' => [
                                'audio/aac',
                                'audio/mpeg',
                                'audio/ogg',
                                'audio/opus',
                                'audio/3gpp',
                                'audio/3gpp2',
                                'audio/wav',
                                'audio/webm',
                                'audio/midi',
                                'audio/x-midi',
                                ]
                            ])
                        ],
                        'required'   => false,
                    ]
                )
            ->add('linkone', TextType::class,[
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/(?:http(?:s){0,1}:\/\/){1}(?:www.){0,1}(?:.){0,1}[a-zA-Z0-9ââàëêéèïîöôùüû?=_\-\/]*(?:.){1}[a-zA-Z0-9]{2,4}[\/]{0,1}[a-zA-Z0-9ââàëêéèïîöôùüû?=_\-\/]*/',
                        'message' => 'Votre Url est invalide'
                    ]
                    )
                ],
                'required'   => false,
            ])
            
            ->add('linktwo',TextType::class,[
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/(?:http(?:s){0,1}:\/\/){1}(?:www.){0,1}(?:.){0,1}[a-zA-Z0-9ââàëêéèïîöôùüû?=_\-\/]*(?:.){1}[a-zA-Z0-9]{2,4}[\/]{0,1}[a-zA-Z0-9ââàëêéèïîöôùüû?=_\-\/]*/',
                        'message' => 'Votre Url est invalide'
                    ]
                    )
                ],
                'required'   => false,
            ])

            ->add('linkthree', TextType::class,[
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/(?:http(?:s){0,1}:\/\/){1}(?:www.){0,1}(?:.){0,1}[a-zA-Z0-9ââàëêéèïîöôùüû?=_\-\/]*(?:.){1}[a-zA-Z0-9]{2,4}[\/]{0,1}[a-zA-Z0-9ââàëêéèïîöôùüû?=_\-\/]*/',
                        'message' => 'Votre Url est invalide'
                    ]
                    )
                ],
                'required'   => false,
            ])

            ->add('cover', 
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
                        'data_class' => null,
                    ]
                )

            ->add('description')

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
