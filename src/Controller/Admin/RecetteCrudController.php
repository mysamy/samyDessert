<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use App\Enum\Difficulte;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RecetteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recette::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setEntityLabelInSingular('Recette')
            ->setEntityLabelInPlural('Recettes');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('titre', 'Titre');
        yield BooleanField::new('isPublished', 'Publiée');
        yield AssociationField::new('categorie', 'Catégorie')->setRequired(false);
        yield AssociationField::new('produit', 'Produit lié')
            ->setRequired(false)
            ->setHelp('Laisser vide pour une recette standalone');
        yield ChoiceField::new('difficulte', 'Difficulté')
            ->setRequired(false)
            ->setChoices([
                'Facile'    => Difficulte::Facile,
                'Moyen'     => Difficulte::Moyen,
                'Difficile' => Difficulte::Difficile,
            ]);
        yield IntegerField::new('duree', 'Durée (min)')->setRequired(false);
        yield IntegerField::new('portions', 'Portions')->setRequired(false);
        yield ImageField::new('imageName', 'Image actuelle')
            ->setBasePath('/uploads/recettes')
            ->onlyOnIndex();

        yield TextField::new('imageFile', 'Image')
            ->setFormType(VichImageType::class)
            ->setFormTypeOptions([
                'required'     => false,
                'allow_delete' => true,
                'download_uri' => false,
            ])
            ->onlyOnForms();
        yield TextField::new('slug', 'Slug')->setRequired(false)->hideOnIndex();
        yield TextareaField::new('description', 'Description courte')->setRequired(false)->hideOnIndex();
        yield TextareaField::new('contenu', 'Contenu')->hideOnIndex();
        yield DateTimeField::new('createdAt', 'Créée le')
            ->setFormat('dd/MM/yyyy')
            ->onlyOnIndex();
    }
}
