<?php

namespace App\Controller\Admin;

use App\Entity\Plant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Plant::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('plantPicture', 'Image')
                ->setBasePath('/images/default')
                ->onlyOnIndex(),

            TextField::new('name', 'Nom'),
            TextField::new('category', 'Catégorie'),
            TextEditorField::new('description', 'Description'),
            TextField::new('plantPicture', 'Nom du fichier image')
                ->hideOnIndex(),

            DateField::new('sowingPeriodStart', 'Début semis')
            ->hideOnIndex(),
            DateField::new('sowingPeriodEnd', 'Fin semis')
            ->hideOnIndex(),
            DateField::new('plantingPeriodStart', 'Début plantation')
            ->hideOnIndex(),
            DateField::new('plantingPeriodEnd', 'Fin plantation')
            ->hideOnIndex(),
            DateField::new('harvestPeriodStart', 'Début récolte')
            ->hideOnIndex(),
            DateField::new('harvestPeriodEnd', 'Fin récolte')
            ->hideOnIndex(),

            TextEditorField::new('germinationDetails', 'Germination'),
            TextEditorField::new('cultivationDetails', 'Conseils de culture'),

            IntegerField::new('growingTime', 'Temps de pousse (jours)')
            ->hideOnIndex(),
            IntegerField::new('waterNeed', 'Besoin en eau')
            ->hideOnIndex(),
            IntegerField::new('sunlightNeed', 'Ensoleillement')
            ->hideOnIndex(),

            TextareaField::new('soilNeed', 'Besoins en sol'),

            BooleanField::new('supportNeed', 'Besoin de tuteur ?'),

            AssociationField::new('family', 'Famille')->autocomplete(),
            AssociationField::new('areas', 'Zones de culture')->setFormTypeOption('by_reference', false),
        ];
    }
}
