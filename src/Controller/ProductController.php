<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Product;
use App\Form\DashboardProductFormType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

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

    //Route de modification de produits
    #[Route(path: '/product/{id}/update', name: 'app_product_update')]
    function updateProduct(Request $request, Product $product): Response
    {
        $updateForm = $this->createForm(DashboardProductFormType::class, $product);
        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()) {
            $productName = $product->getName();
            $slug = str_replace(' ', '_', strtolower($productName));
            $product->setSlug($slug);
            $this->em->flush();
            return $this->redirectToRoute('app_dashboard',["action" => 2]);
        }

        return $this->render('dashboard/index.html.twig', [
            'action' => 'update_product',
            'company_id' => $this->getUser()->getCompany()->getId(),
            'updateForm' => $updateForm->createView()
        ]);
    }

    //Route de suppression de produits
    #[Route(path: '/product/{id}/delete', name: 'app_product_delete')]
    function deleteProduct(Request $request, Product $product): Response
    {
        $this->em->remove($product);
        $this->em->flush();
        return $this->redirectToRoute('app_dashboard',["action" => 2]);
    }
}
