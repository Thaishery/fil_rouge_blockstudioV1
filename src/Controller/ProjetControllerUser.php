<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Projet;
use App\Form\ProjetTypeUser;
use App\Repository\ProjetRepository;
use Symfony\Component\HttpFoundation\File\File;
use App\Repository\UserRepository;
use App\Service\CoverFileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
     public function new(Request $request, User $user, CoverFileUploader $coverFileUploader): Response
     {
         $user=$this->getUser();
         $projet = new Projet();
         $form = $this->createForm(ProjetTypeUser::class, $projet);
         $form->handleRequest($request);
         $projet ->setCreateur($user);
         $projet ->setYears(new \DateTime('now'));

         if ($form->isSubmitted() && $form->isValid())
             {

                 $cover = $form->get('cover')->getData();

                     if ($cover)
                         {
                         $coverName = $coverFileUploader->upload($cover);
                         $projet->setCover($coverName);
                         }

                     else
                         {
                         $projet->setCover('placeholder.jpg');
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
    public function edit(Request $request, Projet $projet, CoverFileUploader $fileUploader ): Response
    {
        $user = $this ->getUser();
        $form = $this ->createForm(ProjetTypeUser::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('cover')->getData();
            
            if($file) {
                $fileName = $fileUploader->upload($file);
                $projet->setCover($fileName);
            } else {
                $file = $projet->getCover();
                $projet->setCover($file);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projet_index_user', ['login' => $user->getlogin(),
            ]);
             
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
