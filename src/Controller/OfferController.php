<?php

namespace App\Controller;

use App\Entity\Offer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OfferController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Offer::class;
    }
}
