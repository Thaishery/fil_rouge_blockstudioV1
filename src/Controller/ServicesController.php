<?php

namespace App\Controller;

use App\Entity\Services;
use App\Form\ServicesType;
use App\Repository\ServicesRepository;
use App\Service\CoverFileUploader;
use App\Service\PictureFileUploader;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/services")
 * @IsGranted("ROLE_ADMIN")
 */
class ServicesController extends AbstractController
{
    /**
     * @Route("/", name="services_index", methods={"GET"})
     */
    public function index(ServicesRepository $servicesRepository): Response
    {
        return $this->render('services/index.html.twig', [
            'services' => $servicesRepository->findAll(),
            
        ]);
    }

    /**
     * @Route("/new", name="services_new", methods={"GET","POST"})
     */
    public function new(Request $request, PictureFileUploader $fileUploader,ServicesRepository $servicesRepository): Response
    {

        $services = new Services();
        $form = $this->createForm(ServicesType::class, $services);
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $picture = $form->get('picture')->getData();

             if ($picture){
                 $pictureName = $fileUploader->upload($picture);
                 $services->setPicture($pictureName);
             }

             else{
                $services->setPicture('placeholder.jpg');
             }

             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($services);
             $entityManager->flush();

             return $this->redirectToRoute('services_index');
         }

        return $this->render('services/new.html.twig', [
            'service' => $services,
            'services' => $servicesRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="services_show", methods={"GET"})
     */
    public function show(Services $service,ServicesRepository $services): Response
    {{}
        return $this->render('services/show.html.twig', [
            'service' => $service,
            'services' => $services->findAll(),
        ]);
    }


    
    /**
     * @Route("/{id}/edit", name="services_edit", methods={"GET","POST"})
     */
     public function edit(Request $request, Services $service, PictureFileUploader $fileUploader,ServicesRepository $services): Response
     {
         $form = $this->createForm(ServicesType::class, $service);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $file = $form->get('picture')->getData();
                 
             if($file) {
                 $fileName = $fileUploader->upload($file);
                 $service->setPicture($fileName);
             } else {
                 $file = $service->getPicture();
                 $service->setPicture($file);
             }

             $this->getDoctrine()->getManager()->flush();

             return $this->redirectToRoute('services_index',[
                'services' => $services->findAll(),
             ]);
         }

        return $this->render('services/edit.html.twig', [
            'service' => $service,
            'services' => $services->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="services_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Services $service,ServicesRepository $services): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('services_index',[
            'services' => $services->findAll(),
        ]);
    }
}
