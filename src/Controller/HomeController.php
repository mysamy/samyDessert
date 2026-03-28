<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Contrôleur de la page d'accueil (route "/")
final class HomeController extends AbstractController
{
    // Affiche la page d'accueil du site
    #[Route('/', name: 'app_home')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $meilleursVendus = $produitRepository->findMeilleursVendus(6);

        $carouselProduits = $produitRepository->findBySlugsOrdered([
            'tarte-aux-fraises', 'tiramisu', 'macarons-x6',
            'cheesecake', 'brownies', 'cookies',
        ]);

        return $this->render('home/index.html.twig', [
            'meilleursVendus'  => $meilleursVendus,
            'carouselProduits' => $carouselProduits,
        ]);
    }
}
