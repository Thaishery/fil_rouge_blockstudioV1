<?php

namespace App\Controller;

use App\Repository\ServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivreDorController extends AbstractController
{
    /**
     * @Route("/livre_dor", name="livre_dor")
     */
    public function index(ServicesRepository $services): Response
    {
        return $this->render('livre_dor/index.html.twig', [
            'controller_name' => 'LivreDorController',
            'services' => $services->findAll(),
        ]);
    }
}
