<?php

namespace App\Controller;

use App\Entity\Home;
use App\Form\HomeType;
use App\Repository\HomeRepository;
use App\Repository\ServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/home")
 */
// JC_ Ont gère les accès admin via le fichier " config/packages/security.yaml" et ont a ajouter le admin 

class HomeControllerAdmin extends AbstractController
{

    /**
     * @Route("/", name="home_index", methods={"GET"})
     */
    public function index(HomeRepository $homeRepository,ServicesRepository $services): Response
    {
        return $this->render('home/indexAdmin.html.twig', [
            'homes' => $homeRepository->findAll(),
            'services' => $services->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="home_new", methods={"GET","POST"})
     */
    public function new(Request $request,ServicesRepository $services): Response
    {
        $home = new Home();
        $form = $this->createForm(HomeType::class, $home);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($home);
            $entityManager->flush();

            return $this->redirectToRoute('home_index', [
                'services' => $services->findAll(),
            ]);
        }

        return $this->render('home/new.html.twig', [
            'home' => $home,
            'form' => $form->createView(),
            'services' => $services->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="home_show", methods={"GET"})
     */
    public function show(Home $home,ServicesRepository $services): Response
    {
        return $this->render('home/show.html.twig', [
            'home' => $home,
            'services' => $services->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="home_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Home $home,ServicesRepository $services): Response
    {
        $form = $this->createForm(HomeType::class, $home);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home_index', [
                'services' => $services->findAll(),
            ]);
        }

        return $this->render('home/edit.html.twig', [
            'home' => $home,
            'form' => $form->createView(),
            'services' => $services->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="home_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Home $home,ServicesRepository $services): Response
    {
        if ($this->isCsrfTokenValid('delete'.$home->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($home);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home_index', [
            'services' => $services->findAll(),
        ]);
    }
}
