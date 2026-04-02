<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Contrôleur de la page mentions légales (route "/mentions-legales")
class MentionsLegalesController extends AbstractController
{
    // Affiche la page statique des mentions légales
    #[Route('/mentions-legales', name: 'app_mentions_legales')]
    public function index(): Response
    {
        return $this->render('mentions_legales/index.html.twig');
    }
}
