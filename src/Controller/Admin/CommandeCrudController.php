<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Enum\StatutCommande;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['dateCommande' => 'DESC'])
            ->setEntityLabelInSingular('Commande')
            ->setEntityLabelInPlural('Commandes');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('reference', 'Référence');
        yield AssociationField::new('utilisateur', 'Client');
        yield DateTimeField::new('dateCommande', 'Date')
            ->setFormat('dd/MM/yyyy HH:mm');
        yield MoneyField::new('total', 'Total')
            ->setCurrency('EUR');
        yield ChoiceField::new('statut', 'Statut')
            ->setChoices([
                'En attente' => StatutCommande::EnAttente,
                'Confirmée'  => StatutCommande::Confirmee,
                'Livrée'     => StatutCommande::Livree,
                'Annulée'    => StatutCommande::Annulee,
            ])
            ->renderAsBadges([
                StatutCommande::EnAttente->value => 'warning',
                StatutCommande::Confirmee->value => 'success',
                StatutCommande::Livree->value    => 'primary',
                StatutCommande::Annulee->value   => 'danger',
            ]);
    }
}
