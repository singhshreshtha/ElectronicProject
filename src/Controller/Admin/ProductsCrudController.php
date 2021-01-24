<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichImageField;
use App\Entity\Products;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Repository\ProductsRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use phpDocumentor\Reflection\Types\Integer;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;


class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
             ->setPermission(Action::DELETE, 'ROLE_ADMIN')
             ->setPermission(Action::EDIT, 'ROLE_MANAGER')
             ->setPermission(Action::NEW, 'ROLE_ADMIN');
    }


    public function configureFields(string $pageName): iterable
    {
        $image = ImageField::new('image')->setBasePath('/images/images');
        $imageFile = VichImageField::new('imageFile');
        $fields = [
            //IdField::new('id'),
            AssociationField::new('manage'),
            AssociationField::new('category_type'),
            TextField::new('product_name'), 
            TextField::new('description'), 
            TextField::new('company_name'), 
            TextField::new('color'), 
            TextField::new('power_consumption'), 
            TextField::new('material_type'), 
            TextField::new('height'), 
            TextField::new('width'), 
            TextField::new('weight'), 
            ChoiceField::new('current_type')->setChoices([
                //'Select' => null,
                 'AC' => 'AC',
                 'DC' => 'DC',
                 ]),
            TextField::new('warranty'), 
            ChoiceField::new('star_ratings')->setChoices([
                //'Select' => null,
                '1'  => '1',
                 '2' => '2',
                 '3' => '3',
                 '4' => '4',
                 '5' => '5', 
                 ]),
            TextField::new('model_no'), 
            ChoiceField::new('status')->setChoices([
                //'Select' => null,
                 'new' => 'new',
                 'review' => 'review',
                 'publish' => 'publish',
                 ]),

            DateTimeField::new('created_at')->hideOnForm()->hideOnIndex(), 
            DateTimeField::new('updated_at')->hideOnForm()->hideOnIndex(),
            NumberField::new('price'),

        ];

        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = $image;
        } else {
            $fields[] = $imageFile;
        }
        return $fields;
    }

    
}