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

            $nom     = trim($request->request->get('nom', ''));
            $email   = trim($request->request->get('email', ''));
            $sujet   = trim($request->request->get('sujet', ''));
            $message = trim($request->request->get('message', ''));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $nom === '' || $message === '') {
                $this->addFlash('error', 'Veuillez remplir tous les champs obligatoires avec un email valide.');
                return $this->redirectToRoute('app_contact');
            }

            $mailer->envoyerMessageContact($nom, $email, $sujet, $message);

            $this->addFlash('success', 'Votre message a bien été envoyé. Nous vous répondrons rapidement !');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig');
    }
}
