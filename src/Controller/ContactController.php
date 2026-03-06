<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            // TODO: envoyer l'email avec Symfony Mailer
            $this->addFlash('success', 'Votre message a bien été envoyé. Nous vous répondrons rapidement !');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig');
    }
}
