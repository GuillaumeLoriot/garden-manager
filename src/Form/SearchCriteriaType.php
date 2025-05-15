<?php

namespace App\Form;

use App\SearchBar\SearchCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchCriteriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', ChoiceType::class, [
                "label" => "Catégorie",
                "choices" => [
                    "Légume" => "legume",
                    "Fruit" => "fruit",
                    "Aromate" => "aromate"
                ]
            ])
            ->add('waterNeed', IntegerType::class, [
                'required' => false,
                'label' => 'Besoin en Eau',
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                ]
            ])
            ->add('sunlightNeed', IntegerType::class, [
                'required' => false,
                'label' => 'Besoin ensoleillement',
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                ]
            ])
            ->add('sowingPeriodSearch', DateType::class, [
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'years' => [2000], 
                'required' => false,
                'label' => 'Période de semis (jour/mois)',
            ])
                        ->add('plantingPeriodSearch', DateType::class, [
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'years' => [2000], 
                'required' => false,
                'label' => 'Période de plantation (jour/mois)',
            ])
                        ->add('harvestPeriodSearch', DateType::class, [
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'years' => [2000], 
                'required' => false,
                'label' => 'Période de récolte (jour/mois)',
            ])


            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchCriteria::class,
            'csrf_protection' => false
        ]);
    }
}
