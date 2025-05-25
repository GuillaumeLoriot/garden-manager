<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {

        // Afin de garantir la sécurité du mot de passe j'enlève la possibilité à l'admin de pouvoir en définir un pour un user
// il faurait plutôt implémenter une logique de réinitialisation de mot de passe accessible au user maisje n'aurais pas le
// temps de le faire pour ce projet avant le rendu.

        return [
            IdField::new('id')->hideOnForm(),

            ImageField::new('profilePicture', 'Photo de profil')
                ->setBasePath('/images/default')
                ->onlyOnIndex(),

            EmailField::new('email', 'E-mail'),

            TextField::new('username', 'Nom d’utilisateur'),

            ArrayField::new('roles', 'Rôles')
                ->setHelp('ROLE_ADMIN , ROLE_USER, Etc..'),

            DateTimeField::new('createdAt', 'Créé le')
                ->hideOnForm(),

            TextEditorField::new('presentation', 'Présentation')
                ->hideOnIndex()
                ->setRequired(false),

            AssociationField::new('images', 'Images')
                ->onlyOnDetail(),

            AssociationField::new('areas', 'Zones')
                ->onlyOnDetail(),
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
