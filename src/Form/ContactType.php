<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Entrez votre email'
            ])
            ->add('sujet', TextType::class, [
                'label' => 'Ecrivez quelque chose..'
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Entrez votre message'
            ])
            ->add('pays', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    'France' => 'from France',
                    'Belgique' => 'from Belgium',
                    'Canada' => 'from Canada',
                    'Suisse' => 'from Switzerland',
                ],
            ])
            ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
