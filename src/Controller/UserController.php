<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserTypeEdit;
use App\Repository\ContactRepository;
use App\Repository\ServicesRepository;
use App\Repository\UserRepository;
use App\Service\AvatarFileUploader;
// use App\Service\FileUploader;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;



/**
 * @Route("/admin/user")
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository,ServicesRepository $services, ContactRepository $contacts): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request,AvatarFileUploader $avatarFileUploader, UserPasswordEncoderInterface $passwordEncoder,ServicesRepository $services, ContactRepository $contacts): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        // $avatar = $user->getAvatar();


        if ($form->isSubmitted() && $form->isValid()) {
            $avatar = $form->get('avatar')->getData();
                 if ($avatar){
                     $avatarName = $avatarFileUploader->upload($avatar);
                     $avatar->setAvatar($avatarName);
                 }
                 else{
                     $avatar->setAvatar('placeholder.jpg');
                 }
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user,ServicesRepository $services, ContactRepository $contacts): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
     //public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    public function edit(Request $request,AvatarFileUploader $fileUploader, User $user,ServicesRepository $services, ContactRepository $contacts): Response
    {
        $form = $this->createForm(UserTypeEdit::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $user->setPassword(
            //     $passwordEncoder->encodePassword(
            //         $user,
            //         $form->get('plainPassword')->getData()
            //     )
            // );
            $file = $form->get('avatar')->getData();
                
                 if($file) {
                     $fileName = $fileUploader->upload($file);
                     $user->setAvatar($fileName);
                 } else {
                     $file = $user->getAvatar();
                     $user->setAvatar($file);
                 }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index',[
                'services' => $services->findAll(),
                'contacts' => $contacts->findAll(),
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user,ServicesRepository $services, ContactRepository $contacts): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index',[
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
        ]);
    }
}
