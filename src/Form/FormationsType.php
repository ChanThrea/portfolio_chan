<?php

namespace App\Form;

use App\Entity\Formations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class/*,['attr' => ['class' => 'form-control']]*/) 
            ->add('dateDebut', BirthdayType::class, ['attr'=>['class'=>'form-control mb-3']])
            ->add('dateFin', BirthdayType::class, ['attr'=>['class'=>'form-control mb-3']])
            ->add('image', TextType::class, ['attr'=>['class'=>'form-control mb-3']])
            ->add('description', TextareaType::class, ['attr'=>['class'=>'form-control mb-3']])
            ->add('submit', SubmitType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formations::class,
        ]);
    }
}
