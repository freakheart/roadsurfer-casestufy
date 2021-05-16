<?php

namespace App\Controller;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }
}
