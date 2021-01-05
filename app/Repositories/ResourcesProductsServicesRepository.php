<?php


namespace App\Repositories;

use DB;
use App\Repositories\Contracts\ResourcesProductsServicesInterface;
use App\Models\ProductsServicesCategories;
use App\Models\ProductsServices;

class ResourcesProductsServicesRepository implements ResourcesProductsServicesInterface
{
    private $models = [];


    public function findCategories()
    {
        $entity = ProductsServicesCategories::select('id', 'name')->orderBy('name');

        if (!$entity) {
            throw new \Exception('Categories not found');
        }

        return $entity->get();
    }
}