<?php

namespace App\Form;

use App\Entity\Categorie;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 3
                ],
                'label' => "Intitulé:",
                'required' => true,
            ])
            ->add('createdAt', DateTimeType::class, [
                'attr' => [
                    'class' => 'form-control js-datepicker'
                ],
                'html5' => false,
                'label' => "Créer le:",
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false,
                'input'  => 'datetime',
            ])
            ->add('updatedAt', DateTimeType::class, [
                'attr' => [
                    'class' => 'form-control js-datepicker'
                ],
                'html5' => false,
                'label' => "Modifier le:",
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false,
                'input'  => 'datetime',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
