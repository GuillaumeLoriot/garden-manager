<?php

namespace App\Controller\Admin;

use App\Entity\Area;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AreaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Area::class;
    }

    public function configureFields(string $pageName): iterable
    {

        // Afin de garantir la sécurité du mot de passe j'enlève la possibilité à l'admin de pouvoir en définir un pour un user
// il faurait plutôt implémenter une logique de réinitialisation de mot de passe accessible au user mais je n'aurais pas le
// temps de le faire pour ce projet avant le rendu.

        return [
            IdField::new('id')->hideOnForm(),

            TextField::new('name', "Nom de la Zone"),

            AssociationField::new('user', 'Propriétaire de la Zone')
                ->setCrudController(UserCrudController::class),

            AssociationField::new('plants', 'Plantes présentes dans la Zone')
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
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
                    ->setLabel('Modifier');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setIcon('fas fa-trash')
                    ->setLabel('Supprimer');
            });
    }
}
