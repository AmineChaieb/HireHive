<?php

namespace App\Controller;

use App\Entity\offre;
use App\Form\offreType;
use App\Repository\offreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/offre')]
class offreController extends AbstractController
{
    #[Route('/', name: 'app_offre_index', methods: ['GET'])]
public function index(OffreRepository $offreRepository): Response
{
    $offres = $offreRepository->findBy(['statut' => 'accepter']);
    return $this->render('offre/index.html.twig', [
        'offres' => $offres,
    ]);
}


    #[Route('/mesOffres', name: 'app_offre_index2', methods: ['GET'])]
public function MesOffres(OffreRepository $offreRepository): Response
{
    // Get the currently authenticated user
    $user = $this->getUser();

    // Get the user's offres
    $offres = $offreRepository->findBy(['user' => $user]);

    return $this->render('offre/index.html.twig', [
        'offres' => $offres,
    ]);
}

    #[Route('/new', name: 'app_offre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, offreRepository $offreRepository): Response
    {
        $offre = new offre();
        $form = $this->createForm(offreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offre->setStatut("En attente");
            $user=$this->getUser();
            $offre->setUser($user);
            $offreRepository->save($offre, true);
            
            

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offre/new.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_offre_show', methods: ['GET'])]
    public function show($id, offreRepository $offreRepository): Response
{
    $offre = $offreRepository->find($id);

    if (!$offre) {
        throw $this->createNotFoundException('Offre not found');
    }

    return $this->render('offre/show.html.twig', [
        'offre' => $offre,
    ]);
}

    #[Route('/{id}/edit', name: 'app_offre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, offre $offre, offreRepository $offreRepository): Response
    {
        $form = $this->createForm(offreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offreRepository->save($offre, true);

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offre/edit.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_offre_delete', methods: ['POST'])]
    public function delete(Request $request, offre $offre, offreRepository $offreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getId(), $request->request->get('_token'))) {
            $offreRepository->remove($offre, true);
        }

        return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
