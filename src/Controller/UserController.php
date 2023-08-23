<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\DashboardEmployeeFormType;
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

    //Route de modification d'un utilisateur
    #[Route(path:'/employee/{id}/update', name:'app_employee_update')]

    function updateEmployee(Request $request, User $employee): Response
    {
        $updateForm = $this->createForm(DashboardEmployeeFormType::class, $employee);
        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()) {
            $employeeNumber = $request->get("dashboard_employee_form")["employee_number"];
            $employeeNumber = intval($employeeNumber);
            if ($employeeNumber >= 2 && $employeeNumber < 100){
                $employee->setRoles(["ROLE_CHEF"]);
            } else {
                $employee->setRoles(["ROLE_SERVEUR"]);
            }
            $this->em->flush();
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/index.html.twig', [
            'action' => 'update_employee',
            'company_id' => $this->getUser()->getCompany()->getId(),
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