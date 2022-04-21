<?php

namespace App\Form;

use App\Entity\Competences;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CompetencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('logo', TextType::class, ['attr'=>['class'=>'form-control mb-3']])
            ->add('langage', TextType::class, ['attr'=>['class'=>'form-control mb-3']])
            ->add('description', TextareaType::class, ['attr'=>['class'=>'form-control mb-3']])
            ->add('envoyer', SubmitType::class, ['attr'=>['class'=>'btn btn-success mb-3']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competences::class,
        ]);
    }
}
