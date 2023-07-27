<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\DashboardProductFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class DashboardController extends AbstractController
{

    #[Route('/dashboard', name: 'app_dashboard')]

    public function index(Request $request ): Response
    {
        $product = new Product();
        $form = $this->createForm(DashboardProductFormType::class, $product);

        // Traitez la soumission du formulaire s'il a été envoyé
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
        }

        return $this->render('dashboard/index.html.twig', [
            'form' => $form->createView(),


        ]);
    }
}
