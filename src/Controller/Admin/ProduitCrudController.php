<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('nom', 'Nom');
        yield NumberField::new('prix', 'Prix (€)')->setStoredAsString(true);
        yield BooleanField::new('disponible', 'Disponible');
        yield AssociationField::new('categorie', 'Catégorie')->setRequired(false);
        yield TextField::new('slug', 'Slug')->setRequired(false)->hideOnIndex();
        yield TextareaField::new('description', 'Description')->setRequired(false)->hideOnIndex();

        // Champ upload image via VichUploader
        yield ImageField::new('imageName', 'Image actuelle')
            ->setBasePath('/uploads/produits')
            ->onlyOnIndex();

        yield TextField::new('imageFile', 'Image')
            ->setFormType(VichImageType::class)
            ->setFormTypeOptions([
                'required'      => false,
                'allow_delete'  => true,
                'download_uri'  => false,
            ])
            ->onlyOnForms();
    }
}
