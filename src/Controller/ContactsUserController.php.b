<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Repository\ServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactsUserController extends AbstractController
{
/**
* @Route("/contact/{id}", name="contact_user")
*/
public function show(Contact $contact, ServicesRepository $services, ContactRepository $contacts): Response
{
    return $this->render('contact/vue.html.twig', [
        'contact' => $contact,
        'services' => $services->findAll(),
        'contacts' => $contacts->findAll(),
    ]);
}
}
