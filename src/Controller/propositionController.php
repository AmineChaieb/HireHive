<?php

namespace App\Controller;

use App\Entity\offre;
use App\Entity\proposition;
use App\Form\propositionType;
use App\Repository\offreRepository;
use App\Repository\propositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/proposition')]
class propositionController extends AbstractController
{
    #[Route('/', name: 'app_proposition_index', methods: ['GET'])]
    public function index(propositionRepository $propositionRepository): Response
    {
        return $this->render('proposition/index.html.twig' , [
            'propositions' => $propositionRepository->findAll(),
            
        ]);
        
    }

    #[Route('/prop', name: 'app_proposition_index2', methods: ['GET'])]
public function index2(propositionRepository $propositionRepository): Response
{
    // Get the currently authenticated user
    $user = $this->getUser();

    // Get the user's propositions
    $propositions = $propositionRepository->findBy(['user' => $user]);

    return $this->render('proposition/index.html.twig', [
        'propositions' => $propositions,
    ]);
}

#[Route('/recu', name: 'app_proposition_recu', methods: ['GET'])]
public function recu(propositionRepository $propositionRepository, OffreRepository $offreRepository): Response
{
    // Get the currently authenticated user
    $user = $this->getUser();

    // Get the user's offers
    $offers = $offreRepository->createQueryBuilder('o')
        ->where('o.user = :user')
        ->setParameter('user', $user)
        ->getQuery()
        ->getResult();

    // Get the propositions related to the user's offers
    $propositions = $propositionRepository->createQueryBuilder('p')
        ->leftJoin('p.offre', 'o')
        ->where('o.id IN (:offers)')
        ->setParameter('offers', $offers)
        ->getQuery()
        ->getResult();

        return $this->render('proposition/index.html.twig', [
            'propositions' => $propositions,
            'offers' => $offers,
            'user' => $user,
        ]);
        
}

    #[Route('/new/{offre}', name: 'app_proposition_new', methods: ['GET', 'POST'])]
    public function new(Request $request, propositionRepository $propositionRepository, offre $offre): Response
    {
        $user = $this->getUser();
  
        $proposition = new proposition();
        $proposition->setOffre($offre);
        $proposition->setUser($user);
            
        $form = $this->createForm(propositionType::class, $proposition);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $proposition->setStatut("En attente");
            $propositionRepository->save($proposition, true);
    
            return $this->redirectToRoute('app_proposition_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('proposition/new.html.twig', [
            'proposition' => $proposition,
            'form' => $form,
        ]);
    }
    
    

    #[Route('/{id}', name: 'app_proposition_show', methods: ['GET'])]
public function show(proposition $proposition, EntityManagerInterface $entityManager, offre $offres): Response
{
    $user = $this->getUser();

    $offres = $entityManager->getRepository(offre::class)->findBy([
        'id' => $offres,
    ]);

    return $this->render('proposition/show.html.twig', [
        'offres' => $offres,
        'proposition' => $proposition,
    ]);
}
      

    #[Route('/{id}/edit', name: 'app_proposition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, proposition $proposition, propositionRepository $propositionRepository): Response
    {
        $form = $this->createForm(propositionType::class, $proposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propositionRepository->save($proposition, true);

            // Check if the current user is the owner of the proposition
            $isOwner = $this->getUser() === $proposition->getUser();
    
            $form = $this->createForm(PropositionType::class, $proposition, [
                'is_owner' => ($this->getUser() === $proposition->getOffre()->getUser()),
            ]);

            return $this->redirectToRoute('app_proposition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proposition/edit.html.twig', [
            'proposition' => $proposition,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_proposition_delete', methods: ['POST'])]
    public function delete(Request $request, proposition $proposition, propositionRepository $propositionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$proposition->getId(), $request->request->get('_token'))) {
            $propositionRepository->remove($proposition, true);
        }

        return $this->redirectToRoute('app_proposition_index', [], Response::HTTP_SEE_OTHER);
    }
}
