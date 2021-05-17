<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
// en prévision de la génération de la home page depuis la bdd: 

use App\Entity\Home;
use App\Form\HomeType;
use App\Repository\ContactRepository;
use App\Repository\HomeRepository;
use App\Repository\ServicesRepository;
use Symfony\Component\HttpFoundation\Request;

// fin de prévision. 

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(HomeRepository $homeRepository, AuthenticationUtils $authenticationUtils, ServicesRepository $services, ContactRepository $contacts): Response
    {
    
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'homes' => $homeRepository->findAll(),
            'services' => $services->findAll(),
            'contacts' => $contacts->findAll(),
        ]);
        }
        
    }