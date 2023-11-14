<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\User;
use App\Form\DashboardEmployeeFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

//    #[Route('/{id}/employee', name: 'app_employee')]
//    public function index(Request $request, UserRepository $userRepository, Company $company): Response
//    {
//        $filters =  json_decode($request->query->get("filter"),true);
//        $filters["company"] = $company->getId();
//        $filteredEmployees = $userRepository->findBy($filters);
//        return $this->json([
//            'employees' => $filteredEmployees
//        ]);
//    }

    //Route de modification d'un utilisateur
    #[Route(path: '/employee/{id}/update', name: 'app_employee_update')]
    function updateEmployee(Request $request, User $employee): Response
    {
        $repository = $this->em->getRepository(User::class);
        $updateForm = $this->createForm(DashboardEmployeeFormType::class, $employee);

        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()) {
            try {
                if ($updateForm["employee_number"]->getData() != null) {
                    if (!$repository->findBy(['employee_number' => $updateForm["employee_number"]->getData(), "company" => $this->getUser()->getCompany()->getId()])) {
                        $employee->setEmployeeNumber($updateForm["employee_number"]->getData());
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
            $this->em->flush();
            $this->addFlash('success', "Employé mis à jour avec succès");
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/index.html.twig', [
            'action' => 'update_employee',
            'user_matricule' => $employee->getEmployeeNumber(),
            'company_id' => $this->getUser()->getCompany()->getId(),
            'company_logo' => $this->getUser()->getCompany()->getLogo(),
            'updateForm' => $updateForm->createView()
        ]);
    }

    //Route de suppression d'un utilisateur
    #[Route(path: '/employee/{id}/delete', name: 'app_employee_delete')]
    function deleteEmployee(Request $request, User $employee): Response
    {
        $this->em->remove($employee);
        $this->em->flush();
        return $this->redirectToRoute('app_dashboard');
    }
}