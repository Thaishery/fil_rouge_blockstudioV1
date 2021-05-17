<?php

namespace App\Controller;

use App\Entity\Services;
use App\Repository\ContactRepository;
use App\Repository\ServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
    

class ServiceUserController extends AbstractController
{
/**
* @Route("/service/{id}", name="service_user")
*/
    public function show(Services $service, ServicesRepository $services, ContactRepository $contacts): Response
    {
        return $this->render('services/vue.html.twig', [
            'service' => $service,
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
        ]);
    }
}
