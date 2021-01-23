<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use phpDocumentor\Reflection\Types\Integer;

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
        return [
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
            TextField::new('image'), 
            DateTimeField::new('created_at')->hideOnForm()->hideOnIndex(), 
            DateTimeField::new('updated_at')->hideOnForm()->hideOnIndex(),
            NumberField::new('price'),

        ];
    }

    
}