<?php

namespace App\Controller;

use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CustomerController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }
}
