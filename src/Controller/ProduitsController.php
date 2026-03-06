<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProduitsController extends AbstractController
{
    #[Route('/produits', name: 'app_produits')]
    public function index(Request $request): Response
    {
        $recherche       = trim($request->query->get('q', ''));
        $categorieActive = $request->query->get('categorie', '');

        $allItems = [
            ['title' => 'Tarte aux fraises',        'imageSrc' => '/assets/image/étape1img.png', 'price' => 6.50, 'rating' => 5, 'categorie' => 'tartes'],
            ['title' => 'Tarte au citron meringuée', 'imageSrc' => '/assets/image/étape2img.png', 'price' => 7.00, 'rating' => 5, 'categorie' => 'tartes'],
            ['title' => 'Tarte aux framboises',      'imageSrc' => '/assets/image/étape3img.png', 'price' => 6.50, 'rating' => 4, 'categorie' => 'tartes'],
            ['title' => 'Éclair au chocolat',        'imageSrc' => '/assets/image/étape2img.png', 'price' => 4.00, 'rating' => 4, 'categorie' => 'choux'],
            ['title' => 'Paris-Brest',               'imageSrc' => '/assets/image/étape4img.png', 'price' => 5.50, 'rating' => 5, 'categorie' => 'choux'],
            ['title' => 'Religieuse café',           'imageSrc' => '/assets/image/étape5img.png', 'price' => 4.50, 'rating' => 4, 'categorie' => 'choux'],
            ['title' => 'Macarons (x6)',             'imageSrc' => '/assets/image/étape3img.png', 'price' => 9.00, 'rating' => 5, 'categorie' => 'petits-fours'],
            ['title' => 'Crème brûlée',              'imageSrc' => '/assets/image/étape4img.png', 'price' => 5.50, 'rating' => 4, 'categorie' => 'petits-fours'],
            ['title' => 'Mille-feuille',             'imageSrc' => '/assets/image/étape1img.png', 'price' => 6.00, 'rating' => 5, 'categorie' => 'petits-fours'],
        ];

        $categories = [
            'tartes'      => 'Tartes',
            'choux'       => 'Choux & Éclairs',
            'petits-fours'=> 'Petits fours',
        ];

        $produits = array_values(array_filter($allItems, function ($item) use ($categorieActive, $recherche) {
            if ($categorieActive && $item['categorie'] !== $categorieActive) {
                return false;
            }
            if ($recherche && stripos($item['title'], $recherche) === false) {
                return false;
            }
            return true;
        }));

        return $this->render('produits/index.html.twig', [
            'produits'        => $produits,
            'categories'      => $categories,
            'categorieActive' => $categorieActive,
            'recherche'       => $recherche,
        ]);
    }
}
