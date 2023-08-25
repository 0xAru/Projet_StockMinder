<?php

namespace App\Controller;

use App\Form\ResetPasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Repository\UserRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/forgot-password', name: 'app_forgot_password')]
    public function forgotPassword(
        Request $request,
        UserRepository $userRepository,
        TokenGeneratorInterface $tokenGenerator,
        EntityManagerInterface $em,
        SendMailService $mail
    ): Response {
        $form = $this->createForm(ResetPasswordRequestFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                $email = $form->get('email')->getData();
                $user = $userRepository->findOneBy(['email' => $email]);

                if ($user) {
                    $token = $tokenGenerator->generateToken();
                    $user->setResetToken($token);
                    $em->persist($user);
                    $em->flush();

                    $url = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
                    $context = compact('url', 'user');

                    try {
                        $mail->send(
                            'stockminder@outlook.fr',
                            $user->getEmail(),
                            'Réinitialisation du mot de passe',
                            'password_reset',
                            $context
                        );
                        $this->addFlash('success', 'Email envoyé avec succès');
                    } catch (TransportExceptionInterface $e) {
                        $this->addFlash('danger', 'Erreur lors de l\'envoi de l\'e-mail');
                    }
                } else {
                    $this->addFlash('danger', 'Email invalide');
                }
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView()
        ]);
    }

    #[Route(path:'/forgot-password/{token}', name: 'app_reset_password')]
    public function resetPass(
        string $token,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $userRepository->findOneBy(['reset_token' => $token]);

        if ($user) {
            try {
                $form = $this->createForm(ResetPasswordFormType::class);

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $user->setResetToken('');
                    $user->setPassword(
                        $passwordHasher->hashPassword($user, $form->get('password')->getData())
                    );
                    $em->persist($user);
                    $em->flush();

                    $this->addFlash('success', 'Mot de passe modifié avec succès');
                    return $this->redirectToRoute('app_login');
                }
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur lors de la réinitialisation du mot de passe');
            }

            return $this->render('security/reset_password.html.twig', [
                'passForm' => $form->createView()
            ]);
        }

        $this->addFlash('danger', 'Jeton invalide');
        return $this->redirectToRoute('app_login');
    }
}
