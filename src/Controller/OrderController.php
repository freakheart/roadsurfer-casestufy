<?php

namespace App\Controller;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }
}
