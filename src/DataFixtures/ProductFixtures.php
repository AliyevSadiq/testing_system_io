<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends BaseFixtures
{

    protected function loadData(ObjectManager $manager)
    {
        $products = [
            [
                'title' => 'Iphone',
                'price' => 100
            ],
            [
                'title' => 'Наушники',
                'price' => 20
            ],
            [
                'title' => 'Чехол',
                'price' => 10
            ]
        ];

        foreach ($products as $product) {
            $model = new Product();
            $model->setTitle($product['title'])
                ->setPrice($product['price']);
            $manager->persist($model);
        }

        $manager->flush();
    }
}
