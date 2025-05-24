<?php

namespace App\Form;

use App\SearchBar\SearchCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchCriteriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name', TextType::class, [
                'required' => false,
                "label" => "Nom",
                'attr' => [
                    'placeholder' => 'Entrez un nom de plante',
                ],

            ])
            ->add('category', ChoiceType::class, [
                'required' => false,
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
                    'placeholder' => '0 à 5',
                ]
            ])
            ->add('sunlightNeed', IntegerType::class, [
                'required' => false,
                'label' => 'Besoin ensoleillement',
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                    'placeholder' => '0 à 5',
                ]
            ])
            ->add('sowingPeriodSearch', DateType::class, [
                'widget' => 'choice',
                'format' => 'dd-M-yyyy',
                'years' => [2000],
                'required' => false,
                'label' => 'Période de semis',
                'placeholder' => [
                    'year' => 'Année',
                    'month' => 'Mois',
                    'day' => 'Jour',
                ]
            ])
            ->add('plantingPeriodSearch', DateType::class, [
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'years' => [2000],
                'required' => false,
                'label' => 'Période de plantation',
                'placeholder' => [
                    'year' => 'Année',
                    'month' => 'Mois',
                    'day' => 'Jour',
                ]
            ])
            ->add('harvestPeriodSearch', DateType::class, [
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'years' => [2000],
                'required' => false,
                'label' => 'Période de récolte',
                'placeholder' => [
                    'year' => 'Année',
                    'month' => 'Mois',
                    'day' => 'Jour',
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
            ])

            // j'ai ajouter cete event listener car pour mes filtre, je ne suis interessé que par la periode de l'année pas l'année. 
            // Le problème est que, au submit si je ne remplis pas l'année, ça ne fonctionne pas. 
            // j'ai donc pensé à me brancher avant le submit pour y forcé une année fictive comme celle de ma bdd
            ->addEventListener(FormEvents::PRE_SUBMIT, function (PreSubmitEvent $event) {
                $data = $event->getData();

                foreach (['sowingPeriodSearch', 'plantingPeriodSearch', 'harvestPeriodSearch'] as $searchField) {
                    if (isset($data[$searchField]) && is_array($data[$searchField])) {
                        $day = isset($data[$searchField]['day']) ? $data[$searchField]['day'] : null;
                        $month = isset($data[$searchField]['month']) ? $data[$searchField]['month'] : null;
                        $year = isset($data[$searchField]['year']) ? $data[$searchField]['year'] : null;


                        // je force l'année à 2000 uniquement si day et month sont présents et qu'une donnée est dedans
                        if (!empty($day) && !empty($month)) {
                            $data[$searchField]['year'] = '2000';
                        }
                    }
                }

                $event->setData($data);
            })
            
            ->getForm();

            

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchCriteria::class,
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
