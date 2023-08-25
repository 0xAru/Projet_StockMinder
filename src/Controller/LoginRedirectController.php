<?php
// src/Controller/LoginRedirectController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class LoginRedirectController extends AbstractController
{
    #[Route(path:'/login-redirect', name: 'app_login_redirect')]
    public function redirectAfterLogin()
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($this->generateUrl('app_dashboard'));
        } elseif ($this->isGranted('ROLE_USER')) {
            return new RedirectResponse($this->generateUrl('app_vente'));
        }
    }
}
