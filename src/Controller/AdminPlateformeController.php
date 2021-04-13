<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Plateforme;
use App\Form\PlateformeType;
use App\Repository\PlateformeRepository;
use App\Repository\ServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/plateforme")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminPlateformeController extends AbstractController
{
    /**
     * @Route("/", name="plateforme_index_admin", methods={"GET"})
     */
    public function index(PlateformeRepository $plateformeRepository, ServicesRepository $services): Response
     {
         $user=$this->getUser();   
 
         return $this->render('plateforme/indexAdmin.html.twig', [
             'user' => $user,
            //  'plateformes' => $plateformeRepository-> findBy(array('PlateformeUser'=>$user->getid())),     
            'plateformes' => $plateformeRepository-> findAll(),
            'services' => $services->findAll(),
            ]);
     }

    /**
     * @Route("/new", name="plateforme_new_admin", methods={"GET","POST"})
     */
     public function new(Request $request,  ServicesRepository $services ): Response
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

             return $this->redirectToRoute('plateforme_index_admin',[
                 'login' => $user->getlogin(),
                 'services' => $services->findAll(),]);
         }
       
         return $this->render('plateforme/newAdmin.html.twig', [
             
             'plateforme' => $plateforme,
             'form' => $form->createView(),
             'services' => $services->findAll(),
         ]);
     }

     /**
     * @Route("/{id}", name="plateforme_show_admin", methods={"GET"})
     */
     public function show(Plateforme $plateforme, ServicesRepository $services): Response
     {
         return $this->render('plateforme/show.html.twig', [
             'plateforme' => $plateforme,
             'services' => $services->findAll(),
         ]);
     }

    /**
     * @Route("/{id}/edit", name="plateforme_edit_admin", methods={"GET","POST"})
     */
    public function edit(Request $request, Plateforme $plateforme, ServicesRepository $services): Response
    {
        $form = $this->createForm(PlateformeType::class, $plateforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plateforme_index_admin',[
                'services' => $services->findAll(),
            ]);
        }

        return $this->render('plateforme/editAdmin.html.twig', [
            'plateforme' => $plateforme,
            'form' => $form->createView(),
            'services' => $services->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="plateforme_delete_admin", methods={"DELETE"})
     */
    public function delete(Request $request, Plateforme $plateforme, User $user, ServicesRepository $services): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$plateforme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plateforme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plateforme_index_admin',[
            'login' => $user->getlogin(),
            'services' => $services->findAll(),
            ]);
    }
}
