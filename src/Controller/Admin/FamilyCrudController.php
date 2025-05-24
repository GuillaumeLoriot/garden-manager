<?php

namespace App\Controller\Admin;

use App\Entity\Family;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FamilyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Family::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('familyPicture', 'Image')
                ->setBasePath('/images/default')
                ->onlyOnIndex(),

            TextField::new('name', 'Nom'),
            TextField::new('slug', 'Slug'),

            TextEditorField::new('description', 'Description'),
            TextField::new('familyPicture', 'Nom du fichier image')
                ->hideOnIndex(),

            TextEditorField::new('characteristics', 'Characteristiques générales'),
            TextEditorField::new('history', 'Histoire de la famille'),
            TextEditorField::new('mainUse', 'Utilisation principale'),

            AssociationField::new('plants', 'Plantes associées')->onlyOnDetail()

        ];
    }

    public function configureActions(Actions $actions): Actions
    {

        $detail = Action::new(Action::DETAIL, 'Voir', 'fas fa-eye')
            ->linkToCrudAction(Action::DETAIL);

        return $actions
            ->add(Crud::PAGE_INDEX, $detail)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
            return $action
                ->setIcon('fas fa-pen')
                ->setLabel('Voir');
        })
                ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
            return $action
                ->setIcon('fas fa-trash')
                ->setLabel('Supprimer');
        });      

    }
}
