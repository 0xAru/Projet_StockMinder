<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Form\DashboardProductFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard');
        }

        // Obtenir l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // Dernier nom d'utilisateur entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/dashboard', name: 'app_dashboard')]
    public function dashboard(Request $request): Response
    {

        // Vérifiez si l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer le prénom de l'utilisateur (remplacez 'getFirstName()' par la méthode réelle pour obtenir le prénom)
        $firstName = $this->getUser()->getFirstname();

        // Stocker le prénom dans une variable de session
        $request->getSession()->set('user_name', $firstName);

        $product = new Product();
        $form = $this->createForm(DashboardProductFormType::class, $product);

        // Traitez la soumission du formulaire s'il a été envoyé
        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
//        }

        return $this->render('dashboard/index.html.twig', [
            'form' => $form->createView(),
            'first_name' => $firstName,
            'company_id'=> $this->getUser()->getCompany()->getId(),

        ]);

    }
}
