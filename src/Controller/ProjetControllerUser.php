<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Projet;
use App\Form\ProjetTypeUser;
use App\Repository\ProjetRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

//_GD
// généré par copier coller de ProjetController.php, modification ligne 34 pour n'afficher que la liste des projet de l'utilisateur actuel.
// modification des path pour les templates. 


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
        return $this->render('projet/indexUser.html.twig', [
            // 'id' => $user->getid(),
            // 'login' => $login,
            'user' => $user,
            'projets' => $projetRepository->findBy(array('createur'=>$user->getid())),
        ]);
    }

    /**
     * @Route("/new", name="projet_new_user", methods={"GET","POST"})
     */
    public function new(Request $request, User $user): Response
    {
        $user=$this->getUser();
        $projet = new Projet();
        $form = $this->createForm(ProjetTypeUser::class, $projet);
        $form->handleRequest($request);
        $projet ->setCreateur($user);
        $projet ->setYears(new \DateTime('now'));
        $cover = $projet->getCover();

        if ($form->isSubmitted() && $form->isValid()) {
            
            if ($cover != null){
                $covername = md5(uniqid()).'.'.$cover->guessExtension();
                $cover->move($this->getParameter('cover_directory'), $covername);
                $projet->setCover($covername);
                }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('projet_index_user',['login' => $user->getlogin()] );
        }
        return $this->render('projet/newUser.html.twig', [
            'user' => $user,
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="projet_show_user", methods={"GET"})
     */
    public function show(Projet $projet): Response
    {
        $user=$this->getUser();
        return $this->render('projet/showUser.html.twig', [
            'user' => $user,
            'projet' => $projet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="projet_edit_user", methods={"GET","POST"})
     */
    public function edit(Request $request, Projet $projet): Response
    {
        $user = $this ->getUser();
        $form = $this->createForm(ProjetTypeUser::class, $projet);
        $form->handleRequest($request);
        $cover = $projet->getCover();
        // $curentCover = $this->toString()->$projet->getCover();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($cover != null){
                $covername = md5(uniqid()).'.'.$cover->guessExtension();
                $cover->move($this->getParameter('cover_directory'), $covername);
                $projet->setCover($covername);
                }
            // if ($curentCover != null && $cover == null){
            //     $projet->setCover($curentCover);
            // }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projet_index_user', ['login' => $user->getlogin()]);
        }

        return $this->render('projet/editUser.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="projet_delete_user", methods={"DELETE"})
     */
    public function delete(Request $request, Projet $projet): Response
    {
        $user = $this ->getUser();
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('projet_index_user',['login' => $user->getlogin()]);
    }
}
