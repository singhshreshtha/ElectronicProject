<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Products;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
      //  return parent::index();
      $routerBuilder=$this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routerBuilder->setController
        (UserCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Electronictask');
    }

    public function configureMenuItems(): iterable
    {
       // yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linktoDashboard('User', 'fas fa-address-card')->setPermission('ROLE_ADMIN');
        if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_MANAGER')) {
            yield MenuItem::linkToCrud('Category', 'fas fa-sitemap', Category::class);
        }

        yield MenuItem::linkToCrud('Products', 'fas fa-dice-d6', Products::class);

    }

    /**
     * @Route("/", name="start_page")
     */
    public function home(): Response
    {
        return $this->render('dashboard/index.html.twig', []);
    }
}
