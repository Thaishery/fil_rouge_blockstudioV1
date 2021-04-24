<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/admin/contact")
 */
// JC_ Ont gère les accès admin via le fichier " config/packages/security.yaml" et ont a ajouter le admin  



class ContactControllerAdminController extends AbstractController
{
    /**
     * @Route("/contact/controller/admin", name="contact_controller_admin")
     */
    public function index(): Response
    {
        return $this->render('contact_controller_admin/index.html.twig', [
            'controller_name' => 'ContactControllerAdminController',
        ]);
    }
}
