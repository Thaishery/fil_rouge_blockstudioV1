<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Repository\ServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/contact", name="contact")
     */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact_base")
     */
    public function index(ServicesRepository $services, ContactRepository $contacts): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
        ]);
    }
    
    /**
    * @Route("/{id}", name="contact_show")
    */
    public function listContact(Contact $contact, ServicesRepository $services, ContactRepository $contacts ): Response
    {
        return $this->render('contact/vue.html.twig',[
            'contact' =>$contact,
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
        ]);
    }
}


 