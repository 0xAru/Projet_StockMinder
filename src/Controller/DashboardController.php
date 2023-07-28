<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Form\DashboardEmployeeFormType;
use App\Form\DashboardProductFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class DashboardController extends AbstractController
{

    #[Route('/dashboard', name: 'app_dashboard')]

    public function index(Request $request): Response
    {
        $product = new Product();
        $employee = new User();

        $productForm = $this->createForm(DashboardProductFormType::class, $product);
        $employeeForm = $this->createForm(DashboardEmployeeFormType::class, $employee);

        // Traitez la soumission du formulaire s'il a été envoyé
        $productForm->handleRequest($request);
        $employeeForm->handleRequest($request);

        return $this->render('dashboard/index.html.twig', [
            'productForm' => $productForm->createView(),
            'employeeForm' => $employeeForm->createView()
        ]);
    }
}
