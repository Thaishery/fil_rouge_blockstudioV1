<?php

namespace App\Controller;

use App\Entity\Projet;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtistesController extends AbstractController
{
    /**
     * @Route("/artistes", name="artistes")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        // $projetList = $this->getDoctrine()->getRepository(Projet::class)->findAll();
        $data = $this->getDoctrine()->getRepository(Projet::class)->findAll();
        $projetList = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            12
        );

        return $this->render('artistes/index.html.twig', [
            'controller_name' => 'ArtistesController',
            'projet' => $projetList,
        ]);
    }
}