<?php

namespace App\Form;

use App\Entity\Home;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
// use Symfony\Component\Validator\Constraints\File;

class HomeType extends AbstractType {
    
         public function buildForm(FormBuilderInterface $builder, array $options) {
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
    
                 ->add('long_desc', CKEditorType::class, array (

                     'label' => 'Description longue',
                     
                 ))
    
                 ->add('is_active');

         }
    
         public function configureOptions(OptionsResolver $resolver) {

                 $resolver->setDefaults ( [

                     'data_class' => Home::class,

                 ]);

         }

     }
