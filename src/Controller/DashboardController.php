<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
class DashboardController extends AbstractController
{

    #[Route('/dashboard', name: 'app_dashboard')]

    public function index(): Response
    {

        dd('hghghg');
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
//            'companyId'=>
        ]);
    }
}
