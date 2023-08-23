<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Product;
use App\Entity\User;
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
        $company = $this->getUser()->getCompany();

        //Récupération des différentes options pour les champs select du formulaire
        $filterOptions = [
            'label_choices' => $productRepository->findUniqueLabels($company),
            'origin_choices' => $productRepository->findUniqueOrigins($company)
        ];
        // Vérifiez si l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer le prénom de l'utilisateur
        $firstName = $this->getUser()->getFirstname();

        // Stocker le prénom dans une variable de session
        $request->getSession()->set('user_name', $firstName);


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
            $employeeNumber = $request->get("dashboard_employee_form")["employee_number"];
            $employeeNumber = intval($employeeNumber);
            if ($employeeNumber >= 2 && $employeeNumber < 100){
                $employee->setRoles(["ROLE_CHEF"]);
            } else {
                $employee->setRoles(["ROLE_SERVEUR"]);
            }
            $employee->setResetToken('');
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
            'company_logo' => $this->getUser()->getCompany()->getLogo(),
            'productForm' => $productForm->createView(),
            'employeeForm' => $employeeForm->createView(),
            'eventForm' => $eventForm->createView(),
            'route' => "dashboard",
        ]);
    }

}