<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichImageField;
use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Repository\ProductsRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use phpDocumentor\Reflection\Types\Integer;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Component\HttpFoundation\HeaderUtils;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class ProductsCrudController extends AbstractCrudController

{
   
    public function __construct(
        AdminUrlGenerator $adminUrlGenerator, 
        CategoryRepository $CategoryRepository, 
        UserRepository $UserRepository, 
        ProductsRepository $ProductsRepository, 
        SluggerInterface $slugger,
        LoggerInterface $logger
    ) {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->CategoryRepository = $CategoryRepository;
        $this->UserRepository = $UserRepository;
        $this->ProductsRepository = $ProductsRepository;
        $this->slugger = $slugger;
        $this->logger = $logger;
    }
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        
        $importPostButton = Action::new('importPost', 'Import')->setCssClass('btn btn-default')->createAsGlobalAction()->linkToCrudAction('importPost');
        $exportPostButton = Action::new('exportPost', 'Export')->setCssClass('btn btn-default')->createAsGlobalAction()->linkToCrudAction('exportPost');
        if ($this->isGranted('ROLE_ADMIN')){
            return $actions
            ->add(Crud::PAGE_INDEX, $importPostButton)
             ->add(Crud::PAGE_INDEX, $exportPostButton);


        }
        else if ($this->isGranted('ROLE_MANAGER')){
            return $actions
            
             ->add(Crud::PAGE_INDEX, $exportPostButton);


        }

        else{
    
        return $actions
           
             ->setPermission(Action::DELETE, 'ROLE_ADMIN')
             ->setPermission(Action::EDIT, 'ROLE_MANAGER')
             ->setPermission(Action::NEW, 'ROLE_ADMIN');
        }
    }


    public function configureFields(string $pageName): iterable
    {
        $image = ImageField::new('image')->setBasePath('/images');
        $imageFile = VichImageField::new('imageFile');
        $fields = [
            //IdField::new('id'),
            AssociationField::new('manage')->setPermission('ROLE_ADMIN'),
            AssociationField::new('category_type')->setPermission('ROLE_MANAGER'),
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

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('product_name')
            ->add('price')
            ->add('category_type')
            ;
    }

    public function importPost(Request $request)
    {   global $err_msg;
        $post = new Products();
        $form = $this->createForm(ProductsType::class, $post);        
        $form->handleRequest($request);


        $importedFile = $form->get('import_file')->getData();
        if ($form->isSubmitted() && $importedFile) {
            $jsonData = file_get_contents($importedFile);
            $entityManager = $this->getDoctrine()->getManager();
          ;
            try{
                $postData = json_decode($jsonData);
               
                foreach ($postData as $postItem) {
                    $newPost = new Products();
                    $cat1= $this->UserRepository->find($postItem->manage);
                    $cat= $this->CategoryRepository->find($postItem->category_type);
                    //$newPost->setProductName($postItem->product_name);
                    if((empty($postItem->product_name)) || !(is_string($postItem->product_name)))
                    {
                        $err_msg= "product name has error ";
                    }
                    else{
                        $newPost->setProductName($postItem->product_name);
                    }
                    $newPost->setDescription($postItem->description);
                    $newPost->setCompanyName($postItem->company_name);
                    $newPost->setColor($postItem->color);
                    $newPost->setPowerConsumption($postItem->power_consumption);
                    $newPost->setMaterialType($postItem->material_type);
                    $newPost->setHeight($postItem->height);
                    $newPost->setWidth($postItem->width);
                    $newPost->setWeight($postItem->weight);
                    $newPost->setCurrentType($postItem->current_type);
                    $newPost->setWarranty($postItem->warranty);
                    $newPost->setStarRatings($postItem->star_ratings);
                    $newPost->setModelNo($postItem->model_no);
                    $newPost->setStatus('new');
                    $newPost->setImage($postItem->image);
                    $newPost->setPrice($postItem->price);
                   
                   
                    if(!empty($cat)){
                        $newPost->setCategoryType($cat);
                    }
                    if(!empty($cat1)){
                        $newPost->setManage($cat1);
                    }
                    $newPost->setCreatedAt(new \DateTime());
                    $newPost->setUpdatedAt(new \DateTime());
                    $newPost->setStatus('new');
                    $entityManager->persist($newPost);
                    $entityManager->flush();
                }

                $this->addFlash('success', 'Product(s) data has been imported successfully');
                $this->logger->info('Data imported', $postData);
            } catch (\Exception $e){
                $this->addFlash('error', 'Unable to import '.$err_msg);
                $this->logger->error('Unable to import data correctly.');
            }
        }else{
            $this->logger->error('File was not uploaded');
        }

        return $this->render('admin/product/import.html.twig', [
            'page_title' => 'Import Product',
            'back_link' => $this->adminUrlGenerator->setController(ProductCrudController::class)->setAction(Action::INDEX)->generateUrl(),
            'form' => $form->createView()
        ]);
    }

    public function exportPost()
    {
        try{
            $post = $this->ProductsRepository->findDownloadableData();
            $filename = sprintf("%s_%s.json", 'EXPORT_FILE_POST',microtime(true));
            if(empty($post)){
                $this->addFlash('error', "There are no Products available in the list.");
            }else{
                $response = new Response(json_encode($post));
                $disposition = HeaderUtils::makeDisposition(
                    HeaderUtils::DISPOSITION_ATTACHMENT,
                    $filename
                );

                $response->headers->set('Content-Disposition', $disposition);

                return $response;
            }
        } catch (\Exception $e) {
            $this->addFlash('error', "Something Wrong! Try to find the perfect exception. ");
        }

        return $this->redirect($this->adminUrlGenerator->setController(ProductsCrudController::class)->setAction(Action::INDEX)->generateUrl());
    }
    

    
}