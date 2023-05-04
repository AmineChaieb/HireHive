<?php

namespace App\Controller;

use App\Form\MessagesType;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagesController extends AbstractController
{
    #[Route('/messages', name: 'app_messages')]
    public function index(): Response
    {
        return $this->render('messages/index.html.twig', [
            'controller_name' => 'MessagesController',
        ]);
    }

    #[Route('/send', name: 'app_send')]
    public function send(Request $request, EntityManagerInterface $em): Response
{
    $message = new Message;
    $form = $this->createForm(MessagesType::class, $message);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $message->setSender($this->getUser());
        $message->setIsRead(false);


        $em->persist($message);
        $em->flush();

        $this->addFlash("message", "Message envoyé avec succès.");
        return $this->redirectToRoute('app_messages');
    }

    return $this->render('messages/send.html.twig',[
        'form' => $form->createView()
    ]);

    
    }
    
    #[Route('/received', name: 'app_received')]
    public function received(): Response
    {
        return $this->render('messages/received.html.twig', [
            'controller_name' => 'MessagesController',
        ]);
    }

    #[Route('/read/{id}', name: 'app_read')]
    public function read(Message $message, EntityManagerInterface $em): Response
    {
        $message->setIsRead(true);
        $em->persist($message);
        $em->flush();

        return $this->render('messages/read.html.twig', [
            'controller_name' => 'MessagesController',
            compact("message"),
            'message' => $message
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete(Message $message, EntityManagerInterface $em): Response
    {
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute('app_received')
        ;
    }

    #[Route('/sent', name: 'app_sent')]
    public function sent(): Response
    {
        return $this->render('messages/sent.html.twig', [
            'controller_name' => 'MessagesController',
        ]);
    }

}
