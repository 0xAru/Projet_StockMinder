<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Company;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $stylesOptions = [
            'attr' => [
                'class' => 'flex flex-col items-center'
            ]
        ];

        $form = $this->createForm(RegistrationFormType::class, null, $stylesOptions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupérer les données à partir du formulaire
            $data = $form->getData();

            $user = new User();
            $user->setFirstname($data['director_firstname']);
            $user->setLastname($data['director_lastname']);
            $user->setEmail($data['email']);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setEmployeeNumber(1);
            $user->setRoles(['ROLE_ADMIN']);

            $company = new Company();
            $company->setName($data['company_name']);
            $company->setDirectorFirstname($data['director_firstname']);
            $company->setDirectorLastname($data['director_lastname']);
            $company->setSiret($data['siret_number']);
            $company->setAddress($data['address']);
            $company->setZipcode($data['zipcode']);
            $company->setCity($data['city']);

            // Associez la société à l'utilisateur
            $user->setCompany($company);

            $entityManager->persist($user);
            $entityManager->persist($company);
            $entityManager->flush();

            $session->set('user_firstname', $user->getFirstname());
            $session->set('company_id', $user->getCompany());

            return $this->redirectToRoute('app_dashboard');
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
