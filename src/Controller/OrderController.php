<?php

namespace App\Controller;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield DateField::new('scheduledPickupDate');
        yield DateField::new('scheduledReturnDate');
        yield MoneyField::new('grandTotal')->setCurrency('EUR');
        yield AssociationField::new('pickupStation');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('scheduledPickupDate')
            ->add('scheduledReturnDate')
            ->add('pickupStation')
            ;
    }
}
