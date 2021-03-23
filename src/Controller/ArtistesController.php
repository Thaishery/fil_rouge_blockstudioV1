<?php

namespace App\Controller;

use App\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtistesController extends AbstractController
{
    /**
     * @Route("/artistes", name="artistes")
     */
    public function index(): Response
    {
        $projetList = $this->getDoctrine()->getRepository(Projet::class)->findAll();
        return $this->render('artistes/index.html.twig', [
            'controller_name' => 'ArtistesController',
            'projet' => $projetList,
        ]);
    }
}
