<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/carte', name: 'app_menu')]
    public function index(ProductRepository $productRepository ): Response
    {
        // Appeler l'action index du ProductController pour récupérer les produits
        $products = $productRepository->findAll();

        // Appeler l'action index du EventController pour récupérer les événements
        //$events = $eventController->index();

        // Passez les produits et les événements aux modèles Twig pour les afficher
        return $this->render('menu/index.html.twig', [
            'products' => $products,
            //'events' => $events,
        ]);
    }
}
