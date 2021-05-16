<?php

namespace App\Controller;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }
}
