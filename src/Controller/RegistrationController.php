<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Company;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $company = new Company();

        $form = $this->createForm(RegistrationFormType::class, ['user' => $user, 'company' =>$company]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encoder le mot de passe
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

        // Récupérer les données de la société à partir du formulaire
        $companyData = $form->get('company')->getData();

        $company->setName($companyData['company_name']);
        $company->setDirectorFirstname($company['director_firstname']);
        $company->setDirectorLastname($company['director_lastname']);
        $company->setSiret($company['siret_number']);
        $company->setAddress($company['address']);
        $company->setZipcode($company['zipcode']);
        $company->setCity($company['city']);

        // Associez la société à l'utilisateur
        $user->setCompany($company);

        // Récupérez les données de l'utilisateur à partir du formulaire
        $userData = $form->get('user')->getData();

        $user->setFirstname($userData['director_firstname']);
        $user->setLastname($userData['director_lastname']);
        $user->setEmail($userData['email']);
        $user->setEmployeeNumber(1);
        $user->setRoles(['admin']);

        $entityManager->persist($company);
        $entityManager->persist($user);
        $entityManager->flush();

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
