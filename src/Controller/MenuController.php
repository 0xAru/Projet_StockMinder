<?php

namespace App\Controller;


use App\Form\ProductFilterType;
use App\Repository\EventRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MenuController extends AbstractController
{
    #[Route('/carte', name: 'app_menu')]
    public function index(ProductRepository $productRepository, EventRepository $eventRepository, Request $request ): Response
    {

        // Appeler l'action index du ProductController pour récupérer les événements
        $events = $eventRepository->findAll();


        // Récupérer les options uniques pour les champs du formulaire
        $filterOptions = [
            'style_choices' => $productRepository->findUniqueStyles(),
            'origin_choices' => $productRepository->findUniqueOrigins(),
            'brand_choices' => $productRepository->findUniqueBrands(),
            'capacity_choices' => $productRepository->findUniqueCapacities(),
            'attr' => [
                'class' => 'my-menu w-48', // Ajoutez la classe parent ici
            ],
        ];

        // Créer une instance du formulaire avec les options uniques
        $form = $this->createForm(ProductFilterType::class, null, $filterOptions);

        // Traitez la soumission du formulaire s'il a été envoyé
        $form->handleRequest($request);


        $searchTerm = $request->query->get('search');

        if ($searchTerm !== null) {
            // Filtrez les produits en fonction du terme de recherche
            $products = $productRepository->findProductByKeyword($searchTerm);
        } else if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez les données du formulaire
            $data = $form->getData();

            // Filtrez les produits en fonction des critères choisis dans le formulaire
            $products = $productRepository->findByFilters($data);
        } else {
            // Appeler l'action index du ProductController pour récupérer les produits
            $products = $productRepository->findAll();
        }

        return $this->render('menu/index.html.twig', [
            'events' => $events,
            'products' => $products,
            'searchTerm' => $searchTerm,
            'form' => $form->createView(),
        ]);
    }
}
