<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use App\Controller\Admin\UserCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // return parent::index();
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Html');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Important');
        yield MenuItem::linkToCrud('Categories', 'fa fa-file-word', Category::class);
        yield MenuItem::linkToCrud('Posts', 'fa fa-file-pdf', Product::class);
        // yield MenuItem::subMenu('acc', 'fa fa-file-pdf', User::class);

        // yield MenuItem::subMenu('Blog', 'fa fa-file-pdf')->setSubItems([
            MenuItem::linkToCrud('Categories', 'fa fa-tags', User::class);
            // MenuItem::linkToCrud('Posts', 'fa fa-file-text', Category::class),
            // MenuItem::linkToCrud('Comments', 'fa fa-comment', Category::class),
        // ]);
    }
}
