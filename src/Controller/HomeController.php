<?php

namespace App\Controller;

use App\Repository\offreRepository;
use App\Repository\propositionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', 'home_index', methods: ['GET'])]
    public function index(OffreRepository $offreRepository, propositionRepository $propositionRepository,UserRepository $userRepository): Response
    {
        $offres = $offreRepository->findBy(['statut' => 'accepter']);
        $propositions = $propositionRepository->findAll();
        $user = $userRepository->findAll();
        return $this->render('home.html.twig', [
            'offres' => $offres,
            'propositions' => $propositions,
            'user' => $user,
        ]);
    }
    
    #[Route('/Apropos', 'about_us', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('apropos.html.twig' , [    
        ]);
        
    }
    
}
