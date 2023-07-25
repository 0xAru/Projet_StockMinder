<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\ProductFilterType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{


    #[Route('/{id}/produits', name: 'app_product')]
    public function index(ProductRepository $productRepository, Company $company): Response
    {
        $response = new Response();
        // Récupération tous les produits depuis le ProductRepository
        $products = $company->getProducts();
        return $this->json([
            'products'=>$products,
        ]);
    }
}
