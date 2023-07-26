<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{


    #[Route('/{id}/products', name: 'app_product')]
    public function index(ProductRepository $productRepository, Company $company): Response
    {
        $response = new Response();
        // Récupération tous les produits depuis le ProductRepository
        $products = $company->getProducts();
        return $this->json([
            'products' => $products,
        ]);
    }

}
