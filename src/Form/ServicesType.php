<?php

namespace App\Form;

use App\Entity\Services;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('picture',
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
                         // 'data_class' => null,
                         'mapped' => false,
                     ]
                 )

            ->add('short_desc')
            ->add('long_desc')
            ->add('carousel_rank')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Services::class,
        ]);
    }
}
