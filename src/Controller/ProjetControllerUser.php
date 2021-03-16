<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/user/projet/{login}", methods={"GET"})
 * @IsGranted("ROLE_USER")
 */
class ProjetControllerUser extends AbstractController
{
    
    /**
     * @Route("/", name="projet_index_user", methods={"GET"})
     */
    public function index(ProjetRepository $projetRepository,User $user, string $login): Response
    {
        //$id=$this->getUser()->getid();
        $user=$this->getUser();
        return $this->render('projet/index.html.twig', [
            // 'id' => $user->getid(),
            // 'login' => $login,
            // 'user' => $user,
            'projets' => $projetRepository->findBy(array('createur'=>$user->getid())),
        ]);
    }

    /**
     * @Route("/new", name="projet_new_user", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('projet_index');
        }

        return $this->render('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="projet_show_user", methods={"GET"})
     */
    public function show(Projet $projet): Response
    {
        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="projet_edit_user", methods={"GET","POST"})
     */
    public function edit(Request $request, Projet $projet): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projet_index');
        }

        return $this->render('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="projet_delete_user", methods={"DELETE"})
     */
    public function delete(Request $request, Projet $projet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('projet_index');
    }
}
