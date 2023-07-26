<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{

    #[Route('/{id}/employees', name: 'app_employee')]
    public function index(UserRepository $userRepository, Company $company): Response
    {

        $response = new Response();
        // Récupération tous les employés depuis le UserRepository
        $employees = $company->getUsers();
        return $this->json([
            'employees' => $employees,
        ]);
    }

    #[Route('/{id}/events', name: 'app_event')]
    public function Event(EventRepository $eventRepository, Company $company): Response
    {

        $response = new Response();
        // Récupération tous les employés depuis le UserRepository
        $events = $company->getEvents();
        return $this->json([
            'events' => $events,
        ]);
    }
}