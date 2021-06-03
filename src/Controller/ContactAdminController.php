<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Repository\ServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/contact")
 */
class ContactAdminController extends AbstractController
{
    /**
     * @Route("/", name="contact_admin_index", methods={"GET"})
     */
    public function index(ContactRepository $contactRepository,ServicesRepository $services): Response
    {
        return $this->render('contact_admin/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
            'services' =>$services->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contact_admin_new", methods={"GET","POST"})
     */
    public function new(Request $request, ServicesRepository $services, ContactRepository $contacts): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        // $form = $this->createForm(ContactType::class, $contacte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contact_admin_index',[
                'services' =>$services->findAll(),
                'contacts' => $contacts->findAll(),
            ]);
        }

        return $this->render('contact_admin/new.html.twig', [
            'contacte' => $contact,
            'form' => $form->createView(),
            'services' =>$services->findAll(),
            'contacts' => $contacts->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_admin_show", methods={"GET"})
     */
    public function show(Contact $contacte, ServicesRepository $services, ContactRepository $contacts): Response
    {
        return $this->render('contact_admin/show.html.twig', [
            'contacte' => $contacte,
            'services' =>$services->findAll(),
            'contacts' => $contacts->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contact_admin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contact $contacte, ServicesRepository $services, ContactRepository $contacts): Response
    {
        $form = $this->createForm(ContactType::class, $contacte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_admin_index',[
                'services' => $services->findAll(),
                'contacts' => $contacts->findAll(),
            ]);
        }

        return $this->render('contact_admin/edit.html.twig', [
            'contacte' => $contacte,
            'form' => $form->createView(),
            'services' => $services -> findAll(),
            'contacts' => $contacts->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, Contact $contacte, ServicesRepository $services, ContactRepository $contacts): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contacte->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contacte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_admin_index',[
            'services'=> $services->findAll(),
            'contacts' => $contacts->findAll(),
        ]);
    }
}
