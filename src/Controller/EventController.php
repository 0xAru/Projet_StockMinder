<?php

namespace App\Controller;


use App\Entity\Event;
use App\Entity\User;
use App\Form\DashboardEventFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {

    }

    #[Route(path:'/event/{id}/update', name:'app_event_update')]

    function updateEvent(Request $request, Event $event): Response
    {
        $updateForm = $this->createForm(DashboardEventFormType::class, $event);
        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()) {
            $eventName = $event->getName();
            $slug = str_replace(' ', '_', strtolower($eventName));
            $event->setSlug($slug);

            $uploadedFile = $updateForm['image']->getData();


            if ( $uploadedFile instanceof UploadedFile) {
                $newFilename = uniqid().'.'.$uploadedFile->getClientOriginalExtension();

                $uploadedFile->move($this->getParameter('uploads_path'), $newFilename);

                // Mettre à jour le chemin de l'image dans l'entité
                $event->setImage( $newFilename);

            }
            $this->em->persist($event);
            $this->em->flush();
            return $this->redirectToRoute('app_dashboard', ['action' => 1]);
        }

        return $this->render('dashboard/index.html.twig', [
            'action' => 'update_event',
            'company_id' => $this->getUser()->getCompany()->getId(),
            'company_logo' => $this->getUser()->getCompany()->getLogo(),
            'updateForm' => $updateForm->createView()
        ]);
    }

    //Route de suppression d'un utilisateur
    #[Route(path: '/event/{id}/delete', name: 'app_event_delete')]
    function deleteEvent(Request $request, Event $event): Response
    {
        $this->em->remove($event);
        $this->em->flush();
        return $this->redirectToRoute('app_dashboard', ['action' => 1]);
    }
}