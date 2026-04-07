<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;

class AvisCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Avis::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setEntityLabelInSingular('Avis')
            ->setEntityLabelInPlural('Avis clients');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add(BooleanFilter::new('isValide', 'Validé'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('utilisateur', 'Utilisateur')->onlyOnIndex();
        yield AssociationField::new('produit', 'Produit');
        yield IntegerField::new('note', 'Note')->setHelp('Entre 1 et 5');
        yield TextareaField::new('commentaire', 'Commentaire')->setRequired(false);
        yield BooleanField::new('isValide', 'Validé')->renderAsSwitch(true);
        yield DateTimeField::new('createdAt', 'Date')->onlyOnIndex()->setFormat('dd/MM/yyyy HH:mm');
    }
}
