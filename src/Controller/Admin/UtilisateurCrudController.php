<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            EmailField::new('email', 'Email'),
            TextField::new('prenom', 'Prénom'),
            TextField::new('nom', 'Nom'),
            BooleanField::new('isVerified', 'Email vérifié'),
            ChoiceField::new('roles', 'Rôle')
                ->setChoices(['Admin' => 'ROLE_ADMIN', 'Utilisateur' => 'ROLE_USER'])
                ->allowMultipleChoices()
                ->renderAsBadges([
                    'ROLE_ADMIN' => 'danger',
                    'ROLE_USER'  => 'success',
                ]),
        ];
    }
}
