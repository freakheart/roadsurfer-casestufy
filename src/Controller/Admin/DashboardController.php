<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Offer;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Station;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/welcome.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dashboard')
            ->renderContentMaximized()
            ->disableUrlSignatures();
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Home', 'fa fa-home'),

            MenuItem::linkToCrud('Addresses', 'fas fa-address-card', Address::class),
            MenuItem::linkToCrud('Categories', 'fas fa-copyright', Category::class),
            MenuItem::linkToCrud('Customers', 'fas fa-users', Customer::class),
            MenuItem::linkToCrud('Offers', 'fas fa-tags', Offer::class),
            MenuItem::linkToCrud('Orders', 'fas fa-shopping-cart', Order::class),
            MenuItem::linkToCrud('Products', 'fab fa-product-hunt', Product::class),
            MenuItem::linkToCrud('Stations', 'fas fa-store-alt', Station::class),
        ];
    }
}
