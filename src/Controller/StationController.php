<?php

namespace App\Controller;

use App\Entity\Station;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StationController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Station::class;
    }
}
