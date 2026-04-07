<?php

namespace App\Controller;

use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Contrôleur de la page contact (route "/contact")
final class ContactController extends AbstractController
{
    // Affiche le formulaire de contact et traite l'envoi (POST)
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerService $mailer): Response
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('contact', $request->request->get('_token'))) {
                throw $this->createAccessDeniedException();
            }

            $nom     = $request->request->get('nom', '');
            $email   = $request->request->get('email', '');
            $sujet   = $request->request->get('sujet', '');
            $message = $request->request->get('message', '');

            $mailer->envoyerMessageContact($nom, $email, $sujet, $message);

            $this->addFlash('success', 'Votre message a bien été envoyé. Nous vous répondrons rapidement !');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig');
    }
}
