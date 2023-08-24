<?php

namespace App\Controller;


use App\Entity\Company;
use App\Form\ProductFilterType;
use App\Repository\EventRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MenuController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/carte', name: 'app_menu')]
    public function index(ProductRepository $productRepository, EventRepository $eventRepository, Request $request): Response
    {

        // Appeler l'action index du ProductController pour récupérer les événements
        $events = $eventRepository->findEventsAfterToday('109');


        // Récupérer les options uniques pour les champs du formulaire
        $filterOptions = [
            'style_choices' => $productRepository->findUniqueStyles('109'),
            'origin_choices' => $productRepository->findUniqueOrigins('109'),
            'brand_choices' => $productRepository->findUniqueBrands('109'),
            'capacity_choices' => $productRepository->findUniqueCapacities('109'),
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
            $products = $productRepository->findProductByKeyword($searchTerm, '109');

        } else if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez les données du formulaire
            $data = $form->getData();

            // Filtrez les produits en fonction des critères choisis dans le formulaire
            $products = $productRepository->findByFilters($data, '109');

        } else {
            // Appeler l'action index du ProductController pour récupérer les produits
            $products = $productRepository->findProductsByCompany('109');
        }


        return $this->render('menu/index.html.twig', [
            'events' => $events,
            'products' => $products,
            'searchTerm' => $searchTerm,
            'form' => $form->createView(),
            'companyId' => '109',
        ]);
    }


    //Route carte vente (employés)
    #[Route('/vente', name: 'app_sell')]
    public function sell(ProductRepository $productRepository, EventRepository $eventRepository, Request $request): Response
    {


        // Récupérer les options uniques pour les champs du formulaire
        $filterOptions = [
            'style_choices' => $productRepository->findUniqueStyles('109'),
            'origin_choices' => $productRepository->findUniqueOrigins('109'),
            'brand_choices' => $productRepository->findUniqueBrands('109'),
            'capacity_choices' => $productRepository->findUniqueCapacities('109'),
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
            $products = $productRepository->findProductByKeyword($searchTerm, '109');

        } else if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez les données du formulaire
            $data = $form->getData();

            // Filtrez les produits en fonction des critères choisis dans le formulaire
            $products = $productRepository->findByFilters($data, '109');

        } else {
            // Appeler l'action index du ProductController pour récupérer les produits
            $products = $productRepository->findProductsByCompany('109');

        }

        return $this->render('menu/vente-menu.html.twig', [
            'products' => $products,
            'searchTerm' => $searchTerm,
            'form' => $form->createView(),
            'companyId' => '109',
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

    //Route commande avec mise à jour des stocks (employés)
    #[Route('/stock-update', name: 'app_stockupdate', methods: ['POST'])]
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
