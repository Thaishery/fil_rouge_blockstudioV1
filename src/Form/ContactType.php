<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;




class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
         {
             $builder
                 ->add('login')            
                 ->add('email', EmailType::class); 
                 ->add('long_desc', CKEditorType::class, array(
                    'label' => 'Description longue',
                 ))                    
         }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}