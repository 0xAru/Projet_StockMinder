<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyUpdateFormType;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route(path: '/company_update', name: 'app_company_update')]
    public function companyUpdate(Request $request): Response
    {
        // Vérifiez si l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer l'entité Company associée à l'utilisateur connecté
        $company = $this->getUser()->getCompany();

        // Créer un formulaire pour la mise à jour des informations de l'entité Company
        $companyForm = $this->createForm(CompanyUpdateFormType::class, $company);

        // Traitez la soumission du formulaire s'il a été envoyé
        $companyForm->handleRequest($request);

        if ($companyForm->isSubmitted() && $companyForm->isValid()) {


            $uploadedFile = $companyForm->get('logo')->getData();

            if ($uploadedFile instanceof UploadedFile) {
                $newFilename = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move($this->getParameter('uploads_path'), $newFilename);

                // Mettre à jour le chemin de l'image dans l'entité
                $company->setLogo($newFilename);
            }

            $this->em->flush();

            // Redirigez l'utilisateur vers la page de tableau de bord avec un message de succès
            $this->addFlash('success', 'Les informations de l\'entreprise ont été mises à jour avec succès.');
            return $this->redirectToRoute('app_dashboard');
        }

        // Rendre le formulaire de mise à jour de l'entité Company
        return $this->render('dashboard/company_update.html.twig', [
            'company_id' => $this->getUser()->getCompany()->getId(),
            'companyForm' => $companyForm->createView(),
            'company_logo' => $this->getUser()->getCompany()->getLogo(),
        ]);
    }
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