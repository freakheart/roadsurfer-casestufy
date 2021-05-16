<?php

namespace App\Controller;

use App\Entity\Station;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StationController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Station::class;
    }
}
