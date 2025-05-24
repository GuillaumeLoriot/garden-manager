<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            // Affichage de la vignette en index et détail
            ImageField::new('fileName', 'Image')
                ->setBasePath('/images/default')
                ->hideOnForm(),

            DateTimeField::new('createdAt', 'Créé le')
                ->hideOnForm(),

            AssociationField::new('user', "Propriétaire de l'image")
                ->setCrudController(UserCrudController::class)
                ->onlyOnForms(),

            AssociationField::new('user', 'Propriétaire')
                ->onlyOnIndex(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        // Bouton "Voir" en plus de Edit/Delete
        $detail = Action::new(Action::DETAIL, 'Voir', 'fas fa-eye')
            ->linkToCrudAction(Action::DETAIL);

        return $actions
            ->add(Crud::PAGE_INDEX, $detail)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action
                    ->setIcon('fas fa-pen')
                    ->setLabel('Modifier');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setIcon('fas fa-trash')
                    ->setLabel('Supprimer');
            });
    }
}
