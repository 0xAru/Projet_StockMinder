<?php

namespace App\Controller;

use App\Entity\Company;
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

        // Check if the user is logged in
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $company = $this->getUser()->getCompany();
        $repository = $this->em->getRepository(User::class);

        // Retrieval of the different options for the select fields of the form
        $filterOptions = [
            'label_choices' => $productRepository->findUniqueLabels(),
            'origin_choices' => $productRepository->findUniqueOrigins($company)
        ];

        // Get the user's first name
        $firstName = $this->getUser()->getFirstname();

        // Storing the first name in a session variable
        $request->getSession()->set('user_name', $firstName);


        $product = new Product();
        $employee = new User();
        $event = new Event();

        $productForm = $this->createForm(DashboardProductFormType::class, $product, $filterOptions);
        $employeeForm = $this->createForm(DashboardEmployeeFormType::class, $employee);
        $eventForm = $this->createForm(DashboardEventFormType::class, $event);

        // Process the form submission if it has been sent
        $productForm->handleRequest($request);
        $employeeForm->handleRequest($request);
        $eventForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            try {
                $product->setCompany($company);
                $productName = $product->getName();
                $slug = str_replace(' ', '_', strtolower($productName));
                $product->setSlug($slug);
                $this->em->persist($product);
                $this->em->flush();
                return $this->redirectToRoute('app_dashboard', ['action' => 2]);
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Une erreur est survenue lors du traitement du formulaire.');
            }
        }

        if ($employeeForm->isSubmitted() && $employeeForm->isValid()) {
            $employee->setCompany($company);
            try {
                if ($employeeForm["employee_number"]->getData() != null) {
                    if (!$repository->findBy(['employee_number' => $employeeForm["employee_number"]->getData(), "company" => $this->getUser()->getCompany()->getId()])) {
                        $employee->setEmployeeNumber($employeeForm["employee_number"]->getData());
                        $employeeNumber = $employee->getEmployeeNumber();
                        $employeeNumber = intval($employeeNumber);
                        if ($employeeNumber >= 2 && $employeeNumber < 100) {
                            $employee->setRoles(["ROLE_CHEF"]);
                        } else if ($employeeNumber === 1) {
                            $employee->setEmployeeNumber('1');
                            $employee->setRoles(["ROLE_ADMIN"]);
                        } else {
                            $employee->setRoles(["ROLE_SERVEUR"]);
                        }
                    } else {
                        throw new \Exception("Ce matricule est déjà utilisé");
                    }
                }
            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());
                return $this->redirectToRoute('app_dashboard');
            }

            $employee->setEmail($employee->getEmployeeNumber() . "@" . $company->getId());
            $employee->setPassword($this->em->getRepository(Company::class)->findOneBy(['id' => $company])->getEmployeePassword());
            $this->em->flush();
            $employee->setResetToken('');
            $this->em->persist($employee);
            $this->em->flush();
        }

        if ($eventForm->isSubmitted() && $eventForm->isValid()) {
            try {
                $event->setCompany($company);
                $eventName = $event->getName();
                $slug = str_replace(' ', '_', strtolower($eventName));
                $event->setSlug($slug);
                $uploadedFile = $eventForm['image']->getData();

                if ($uploadedFile instanceof UploadedFile) {
                    $newFilename = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

                    $uploadedFile->move($this->getParameter('uploads_path'), $newFilename);

                    // Update image path in entity
                    $event->setImage($newFilename);
                }

                $this->em->persist($event);
                $this->em->flush();
                return $this->redirectToRoute('app_dashboard', ['action' => 1]);
            } catch (\Exception $e) {
                $this->addFlash('danger', 'L\'image ne s\'est pas chargée correctement.');
            }
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