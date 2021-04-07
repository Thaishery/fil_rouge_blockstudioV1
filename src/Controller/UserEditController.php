<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserTypeEditCurrent;
use App\Form\UserType;
use App\Form\UserTypeEdit;
use App\Repository\ServicesRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class UserEditController extends AbstractController
{
    /**
     * @Route("user/{id}/edit", name="user_edit_current", methods={"GET","POST"})
     */
     //public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
     public function edit(Request $request, User $user, int $id,ServicesRepository $services): Response
     {
         $form = $this->createForm(UserTypeEditCurrent::class, $user);
         $form->handleRequest($request);

         //  $id = $this->getUser()->getUsername();
 
         if ($form->isSubmitted() && $form->isValid()) {
             // $user->setPassword(
             //     $passwordEncoder->encodePassword(
             //         $user,
             //         $form->get('plainPassword')->getData()
             //     )
             // );
             $this->getDoctrine()->getManager()->flush();
 
             return $this->redirectToRoute('user_index',[
                'services' => $services->findAll(),
             ]);
         }

         if ($id === $this->getUser()->getid()){
         return $this->render('user/editCurent.html.twig', [
             'id' => $user->getid(),
             'user' => $user,
             'services' => $services->findAll(),
             'form' => $form->createView(),
         ]);
         }
         return $this->render('user/forbiden.html.twig',[
            'services' => $services->findAll(),
         ]);
     }
}
