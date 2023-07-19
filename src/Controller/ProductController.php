<?php

namespace App\Controller;

use App\Form\ProductFilterType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/produits', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        // Récupération tous les produits depuis le ProductRepository
        $products = $productRepository->findAll();

        // Passez les produits récupérés au modèle Twig pour les afficher
        return $this->render('/index.html.twig', [
            'products' => $products,
        ]);
    }
}
