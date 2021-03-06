<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Plateforme;
use App\Form\PlateformeType;
use App\Repository\ContactRepository;
use App\Repository\PlateformeRepository;
use App\Repository\ServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/plateforme/{login}")
 * @IsGranted("ROLE_USER")
 */
class PlateformeController extends AbstractController
{
    /**
     * @Route("/", name="plateforme_index", methods={"GET"})
     */
    public function index(PlateformeRepository $plateformeRepository,User $user, ServicesRepository $services, ContactRepository $contacts): Response
     {
         $user=$this->getUser();   
 
         return $this->render('plateforme/index.html.twig', [
             'user' => $user,
             'plateformes' => $plateformeRepository-> findBy(array('PlateformeUser'=>$user->getid())),     
            // 'plateformes' => $plateformeRepository-> findAll(),
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
            ]);
     }

    /**
     * @Route("/new", name="plateforme_new", methods={"GET","POST"})
     */
     public function new(Request $request, User $user, ServicesRepository $services, ContactRepository $contacts ): Response
     {
         $user=$this->getUser(); 
         $plateforme = new Plateforme();
         $form = $this->createForm(PlateformeType::class, $plateforme);
         $form->handleRequest($request);

         $plateforme -> setPlateformeUser ($user);


         if ($form->isSubmitted() && $form->isValid()) {
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($plateforme);
             $entityManager->flush();

             return $this->redirectToRoute('plateforme_index',[
                 'login' => $user->getlogin(),
                 'services' => $services->findAll(),
                 'contacts' => $contacts->findAll(),
                 ]);
                 
         }
       
         return $this->render('plateforme/new.html.twig', [
             
             'plateforme' => $plateforme,
             'form' => $form->createView(),
             'services' => $services->findAll(),
             'contacts' => $contacts->findAll(),
         ]);
     }

     /**
     * @Route("/{id}", name="plateforme_show", methods={"GET"})
     */
     public function show(Plateforme $plateforme, ServicesRepository $services, ContactRepository $contacts): Response
     {
         return $this->render('plateforme/show.html.twig', [
             'plateforme' => $plateforme,
             'services' => $services->findAll(),
             'contacts' => $contacts->findAll(),
         ]);
     }

    /**
     * @Route("/{id}/edit", name="plateforme_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Plateforme $plateforme, ServicesRepository $services, ContactRepository $contacts): Response
    {
        $form = $this->createForm(PlateformeType::class, $plateforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plateforme_index',[
                'services' => $services->findAll(),
                'contacts' => $contacts->findAll(),
            ]);
        }

        return $this->render('plateforme/edit.html.twig', [
            'plateforme' => $plateforme,
            'form' => $form->createView(),
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="plateforme_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Plateforme $plateforme, User $user, ServicesRepository $services, ContactRepository $contacts): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$plateforme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plateforme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plateforme_index',[
            'login' => $user->getlogin(),
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
            ]);
    }
}
