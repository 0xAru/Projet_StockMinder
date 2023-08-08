<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Product;
use App\Entity\User;
use App\Form\CompanyUpdateFormType;
use App\Form\DashboardEmployeeFormType;
use App\Form\DashboardEventFormType;
use App\Form\DashboardProductFormType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route(path: '/dashboard', name: 'app_dashboard')]
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        //Récupération des différentes options pour les champs select du formulaire
        $filterOptions = [
            'label_choices' => $productRepository->findUniqueLabels(),
            'origin_choices' => $productRepository->findUniqueOrigins()
        ];
        // Vérifiez si l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer le prénom de l'utilisateur
        $firstName = $this->getUser()->getFirstname();

        // Stocker le prénom dans une variable de session
        $request->getSession()->set('user_name', $firstName);

        $company = $this->getUser()->getCompany();
        $product = new Product();
        $employee = new User();
        $event = new Event();

        $productForm = $this->createForm(DashboardProductFormType::class, $product, $filterOptions);
        $employeeForm = $this->createForm(DashboardEmployeeFormType::class, $employee);
        $eventForm = $this->createForm(DashboardEventFormType::class, $event);

        // Traitez la soumission du formulaire s'il a été envoyé
        $productForm->handleRequest($request);
        $employeeForm->handleRequest($request);
        $eventForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $product->setCompany($company);
            $productName = $product->getName();
            $slug = str_replace(' ', '_', strtolower($productName));
            $product->setSlug($slug);
            $this->em->persist($product);
            $this->em->flush();
            return $this->redirectToRoute('app_dashboard', ['action' => 2]);
        }

        if ($employeeForm->isSubmitted() && $employeeForm->isValid()) {
            $employee->setCompany($company);
            $role = $request->get("dashboard_employee_form")["roles"];
            $employee->setRoles([$role]);
            $this->em->persist($employee);
            $this->em->flush();
        }

        if ($eventForm->isSubmitted() && $eventForm->isValid()) {
            $event->setCompany($company);
            $eventName = $event->getName();
            $slug = str_replace(' ', '_', strtolower($eventName));
            $event->setSlug($slug);
            $uploadedFile = $eventForm['image']->getData();

            if ($uploadedFile instanceof UploadedFile) {
                $newFilename = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

                $uploadedFile->move($this->getParameter('uploads_path'), $newFilename);

                // Mettre à jour le chemin de l'image dans l'entité
                $event->setImage($newFilename);

            }
            $this->em->persist($event);
            $this->em->flush();
            return $this->redirectToRoute('app_dashboard', ['action' => 1]);

        }

        return $this->render('dashboard/index.html.twig', [
            'first_name' => $firstName,
            'company_id' => $this->getUser()->getCompany()->getId(),
            'productForm' => $productForm->createView(),
            'employeeForm' => $employeeForm->createView(),
            'eventForm' => $eventForm->createView(),
            'route' => "dashboard",
        ]);
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
            $this->em->flush();

            // Redirigez l'utilisateur vers la page de tableau de bord avec un message de succès
            $this->addFlash('success', 'Les informations de l\'entreprise ont été mises à jour avec succès.');
            return $this->redirectToRoute('app_dashboard');
        }
        // Rendre le formulaire de mise à jour de l'entité Company
        return $this->render('dashboard/company_update.html.twig', [
            'company_id' => $this->getUser()->getCompany()->getId(),
            'companyForm' => $companyForm->createView()
        ]);
    }
}