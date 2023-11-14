<?php

namespace App\Controller;

use App\Form\ProductFilterType;
use App\Repository\EventRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class MenuController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/carte', name: 'app_menu')]
    public function index(ProductRepository $productRepository, EventRepository $eventRepository, Request $request): Response
    {

//Récupération du companyId (sera récupéré dans l'URL pour la carte)

        $company = $this->getUser()->getCompany();
        $companyId = $company->getId();

        // Appeler l'action index du ProductController pour récupérer les événements
        $events = $eventRepository->findEventsAfterToday($companyId);


        // Récupérer les options uniques pour les champs du formulaire
        $filterOptions = [
            'style_choices' => $productRepository->findUniqueStyles($companyId),
            'origin_choices' => $productRepository->findUniqueOrigins($companyId),
            'brand_choices' => $productRepository->findUniqueBrands($companyId),
            'capacity_choices' => $productRepository->findUniqueCapacities($companyId),
            'attr' => [
                'class' => 'my-menu w-48',
            ],
        ];

        // Créer une instance du formulaire avec les options uniques
        $form = $this->createForm(ProductFilterType::class, null, $filterOptions);

        // Traitez la soumission du formulaire s'il a été envoyé
        $form->handleRequest($request);


        $searchTerm = $request->query->get('search');

        if ($searchTerm !== null) {
            // Filtrez les produits en fonction du terme de recherche
            $products = $productRepository->findProductByKeyword($searchTerm, $companyId);

        } else if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez les données du formulaire
            $data = $form->getData();

            // Filtrez les produits en fonction des critères choisis dans le formulaire
            $products = $productRepository->findByFilters($data, $companyId);

        } else {
            // Appeler l'action index du ProductController pour récupérer tous les produits
            $products = $productRepository->findProductsByCompany($companyId);
        }


        return $this->render('menu/index.html.twig', [
            'events' => $events,
            'products' => $products,
            'searchTerm' => $searchTerm,
            'form' => $form->createView(),
            'companyId' => $companyId,
        ]);
    }


    //Route carte vente (employés)
    #[Route('/vente', name: 'app_sell')]
    public function sell(ProductRepository $productRepository, EventRepository $eventRepository, UserRepository $userRepository, Request $request): Response
    {
        $company = $this->getUser()->getCompany();
        $companyId = $company->getId();


        // Récupérer les options uniques pour les champs du formulaire
        $filterOptions = [
            'style_choices' => $productRepository->findUniqueStyles($companyId),
            'origin_choices' => $productRepository->findUniqueOrigins($companyId),
            'brand_choices' => $productRepository->findUniqueBrands($companyId),
            'capacity_choices' => $productRepository->findUniqueCapacities($companyId),
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
            $products = $productRepository->findProductByKeyword($searchTerm, $companyId);

        } else if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez les données du formulaire
            $data = $form->getData();

            // Filtrez les produits en fonction des critères choisis dans le formulaire
            $products = $productRepository->findByFilters($data, $companyId);

        } else {
            // Appeler l'action index du ProductController pour récupérer les produits
            $products = $productRepository->findProductsByCompany($companyId);
        }

        return $this->render('menu/vente-menu.html.twig', [
            'products' => $products,
            'searchTerm' => $searchTerm,
            'form' => $form->createView(),
            'companyId' => $companyId,
            'route' => "vente" //Afin d'afficher ou non la déconnection sur la carte (vente=>oui, carte=>non)
        ]);
    }


    //Route commande avec mise à jour des stocks (employés)
    #[Route('/order', name: 'app_order', methods: ['POST'])]
    public function order(ProductRepository $productRepository, Request $request): void
    {
        $products = json_decode($request->getContent());
        foreach ($products as $product) {
            $dataProd = $productRepository->find($product->id);
            $dataProd->setStock($product->stock);
            $this->em->persist($dataProd);
        }
        $this->em->flush();
    }

    //Route de mise à jour manuelle des stocks (chef de salle)
    #[Route('/stock-update', name: 'app_stockupdate', methods: ['POST'])]
    #[IsGranted('ROLE_CHEF')]
    public function stockUpdate(ProductRepository $productRepository, Request $request): void
    {
        $products = json_decode($request->getContent());
        foreach ($products as $product) {
            $dataProd = $productRepository->find($product->id);
            $dataProd->setStock($product->stock);
            $this->em->persist($dataProd);
        }

        $this->em->flush();

    }
}
