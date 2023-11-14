<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Company;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\UserAuthenticator;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,
                             UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator,
                             EntityManagerInterface $entityManager, SessionInterface $session): Response
    {

        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Get data from form
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
            $user->setResetToken('');

            $company = new Company();
            $company->setName($data['company_name']);
            $company->setDirectorFirstname($data['director_firstname']);
            $company->setDirectorLastname($data['director_lastname']);
            $company->setSiret($data['siret_number']);
            $company->setAddress($data['address']);
            $company->setZipcode($data['zipcode']);
            $company->setCity($data['city']);
            $company->setEmployeePassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('employee_password')->getData()
                )
            );
            $uploadedFile = $data['logo'];

            if ($uploadedFile instanceof UploadedFile) {
                $newFilename = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move($this->getParameter('uploads_path'), $newFilename);

                // Update image path in entity
                $company->setLogo($newFilename);
            }

            // Associate the company with the user
            $user->setCompany($company);

            $entityManager->persist($user);
            $entityManager->persist($company);
            $entityManager->flush();

            $session->set('user_firstname', $user->getFirstname());
            $session->set('company_id', $user->getCompany());
            $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
            return $this->redirectToRoute('app_dashboard');
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
