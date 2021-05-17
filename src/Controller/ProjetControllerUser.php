<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Entity\Projet;
use App\Form\ProjetTypeUser;
use App\Form\SearchProjetType;
use App\Repository\ContactRepository;
use App\Repository\ProjetRepository;
use App\Repository\ServicesRepository;
use Symfony\Component\HttpFoundation\File\File;
use App\Repository\UserRepository;
use App\Service\CoverFileUploader;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

//_GD
// généré par copier coller de ProjetController.php, modification ligne 34 pour n'afficher que la liste des projet de l'utilisateur actuel.
// modification des path pour les templates. 

//_GD route de base : @Route("/user/projet/{login}", methods={"GET"})
/**
 * @Route("/user/projet/{login}")
 * @IsGranted("ROLE_USER")
 */
class ProjetControllerUser extends AbstractController
{
    
    /**
     * @Route("/", name="projet_index_user", methods={"GET"})
     */
    public function index(ProjetRepository $projetRepository,User $user, string $login,ServicesRepository $services, ContactRepository $contacts): Response
    {
         //$id=$this->getUser()->getid();
         $user=$this->getUser();
         return $this->render('projet/indexUser.html.twig', [
             // 'id' => $user->getid(),
             // 'login' => $login,
             'user' => $user,
             'services' => $services->findAll(),
             'contacts' => $contacts->findAll(),
             'projets' => $projetRepository->findBy(array('createur'=>$user->getid())),
         ]);
     }

     /**
     * @Route("/new", name="projet_new_user", methods={"GET","POST"})
     */
     public function new(Request $request, User $user, CoverFileUploader $coverFileUploader,ServicesRepository $services, ContactRepository $contacts): Response
     {
         //GD_ ajout de l'utilisateur
         $user=$this->getUser();
         // Crud de base
         $projet = new Projet();
         $form = $this->createForm(ProjetTypeUser::class, $projet);
         $form->handleRequest($request);
         $projet ->setCreateur($user);
         $projet ->setYears(new \DateTime('now'));

         if ($form->isSubmitted() && $form->isValid())
             {
                 $cover = $form->get('cover')->getData();
                 //dd($projet);
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

                 return $this->redirectToRoute('projet_index_user',[
                     'login' => $user->getlogin(),
                     'services' => $services->findAll(),
                     'contacts' => $contacts->findAll(),
                     ] );

             }

                 return $this->render('projet/newUser.html.twig', [
                     'user' => $user,
                     'projet' => $projet,
                     'services' => $services->findAll(),
                     'contacts' => $contacts->findAll(),
                     'form' => $form->createView(),
                 ]);
     }

 // *** _GD a mettre en 1er pour eviter confusion avec l'id. ***

     /**
     *  @Route("/search_projet_user", name="projet_search_user")
     */

    public function searchProjet (ProjetRepository $projetRepository, PaginatorInterface $paginator, Request $request,User $user,ServicesRepository $services, ContactRepository $contacts)
    {
        $user= $this->getUser();
        $search_form = $this->createForm(SearchProjetType::class);
        $search_form -> handleRequest($request);

        if ($search_form->isSubmitted() && $search_form->isValid())
             {
                 $value = $search_form->getData();
                //  dd($value);
                $dataList = $projetRepository->findByName($value);
                $projetList = $paginator->paginate(
                    $dataList,
                    $request->query->getInt('page',1),
                    5
                );
                return $this->render('projet/indexUser.html.twig', [
                    // 'id' => $user->getid(),
                    // 'login' => $login,
                    'user' => $user,
                    'services' => $services->findAll(),
                    'contacts' => $contacts->findAll(),
                    'projets' => $projetList,
                ]);
             }

        return $this -> render('search_projet/searchProjet.html.twig', [
            //  'projet' => $projet,
            'login' => $user->getlogin(),
            'user' => $user,
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
            'form' => $search_form -> createView(),
       ]);

    }

    /**
     * @Route("/{id}", name="projet_show_user", methods={"GET"})
     */
    public function show(Projet $projet,ServicesRepository $services, ContactRepository $contacts): Response
    {
        $user=$this->getUser();
        return $this->render('projet/showUser.html.twig', [
            'user' => $user,
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
            'projet' => $projet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="projet_edit_user", methods={"GET","POST"})
     */
    public function edit(Request $request, Projet $projet, CoverFileUploader $fileUploader,ServicesRepository $services, ContactRepository $contacts ): Response
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

            return $this->redirectToRoute('projet_index_user', [
                'login' => $user->getlogin(),
                'services' => $services->findAll(),
                'contacts' => $contacts->findAll(),
            ]);
             
        }

        return $this->render('projet/editUser.html.twig', [
            'projet' => $projet,
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
            'form' => $form->createView(),
            
        ]);
    }

    /**
     * @Route("/{id}", name="projet_delete_user", methods={"DELETE"})
     */
     public function delete(Request $request, Projet $projet,ServicesRepository $services, ContactRepository $contacts): Response
     {
         $user = $this ->getUser();
         if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->remove($projet);
             $entityManager->flush();
         }

         return $this->redirectToRoute('projet_index_user',[
             'login' => $user->getlogin(),
             'services' => $services->findAll(),
             'contacts' => $contacts->findAll(),
             ]);
     }


 }
