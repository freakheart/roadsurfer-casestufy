<?php

namespace App\Controller;

use App\Entity\Address;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AddressController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Address::class;
    }
}
