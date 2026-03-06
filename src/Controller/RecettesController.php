<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecettesController extends AbstractController
{
    #[Route('/recettes', name: 'app_recettes')]
    public function index(Request $request): Response
    {
        $recettes = [
            [
                'id'         => 1,
                'titre'      => 'Tarte au citron meringuée',
                'categorie'  => 'tartes',
                'difficulte' => 'Moyen',
                'temps'      => '1h30',
                'portions'   => 8,
                'image'      => 'https://images.unsplash.com/photo-1519915028121-7d3463d5b1ff?w=600&q=80',
                'description'=> 'Une tarte acidulée avec une meringue légère et croustillante, parfaite pour les amateurs de citron.',
            ],
            [
                'id'         => 2,
                'titre'      => 'Éclair au chocolat',
                'categorie'  => 'choux',
                'difficulte' => 'Difficile',
                'temps'      => '2h',
                'portions'   => 12,
                'image'      => 'https://images.unsplash.com/photo-1602351447937-745cb720612f?w=600&q=80',
                'description'=> 'La pâte à choux maison garnie d\'une crème pâtissière au chocolat noir et glacée à la perfection.',
            ],
            [
                'id'         => 3,
                'titre'      => 'Mousse au chocolat',
                'categorie'  => 'entremets',
                'difficulte' => 'Facile',
                'temps'      => '30 min',
                'portions'   => 6,
                'image'      => 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=600&q=80',
                'description'=> 'Une mousse aérienne et intense au chocolat noir, à préparer la veille pour un résultat optimal.',
            ],
            [
                'id'         => 4,
                'titre'      => 'Macarons à la framboise',
                'categorie'  => 'petits-gateaux',
                'difficulte' => 'Difficile',
                'temps'      => '2h30',
                'portions'   => 20,
                'image'      => 'https://images.unsplash.com/photo-1569864358642-9d1684040f43?w=600&q=80',
                'description'=> 'Des coques légères et croquantes garnies d\'une ganache framboise acidulée et parfumée.',
            ],
            [
                'id'         => 5,
                'titre'      => 'Paris-Brest',
                'categorie'  => 'choux',
                'difficulte' => 'Difficile',
                'temps'      => '2h',
                'portions'   => 8,
                'image'      => 'https://images.unsplash.com/photo-1621955964441-c173e01c135b?w=600&q=80',
                'description'=> 'La couronne de pâte à choux garnie d\'une crème mousseline praliné, un classique de la pâtisserie française.',
            ],
            [
                'id'         => 6,
                'titre'      => 'Tarte aux fraises',
                'categorie'  => 'tartes',
                'difficulte' => 'Facile',
                'temps'      => '1h',
                'portions'   => 8,
                'image'      => 'https://images.unsplash.com/photo-1464305795204-6f5bbfc7fb81?w=600&q=80',
                'description'=> 'Une tarte fraîche avec une crème pâtissière vanille et des fraises de saison disposées à la main.',
            ],
            [
                'id'         => 7,
                'titre'      => 'Fondant au chocolat',
                'categorie'  => 'entremets',
                'difficulte' => 'Facile',
                'temps'      => '45 min',
                'portions'   => 6,
                'image'      => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=600&q=80',
                'description'=> 'Le fondant au coeur coulant, à servir tiède avec une boule de glace vanille pour un dessert irrésistible.',
            ],
            [
                'id'         => 8,
                'titre'      => 'Madeleine au beurre',
                'categorie'  => 'petits-gateaux',
                'difficulte' => 'Facile',
                'temps'      => '45 min',
                'portions'   => 12,
                'image'      => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=600&q=80',
                'description'=> 'Les vraies madeleines de Commercy, moelleuses et beurrées, avec leur bosse caractéristique.',
            ],
            [
                'id'         => 9,
                'titre'      => 'Charlotte aux framboises',
                'categorie'  => 'entremets',
                'difficulte' => 'Moyen',
                'temps'      => '1h + repos',
                'portions'   => 10,
                'image'      => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&q=80',
                'description'=> 'Une charlotte classique aux biscuits à la cuillère et à la mousse framboise, élégante et fraîche.',
            ],
        ];

        $categories = [
            'tartes'        => 'Tartes',
            'choux'         => 'Pâte à choux',
            'entremets'     => 'Entremets',
            'petits-gateaux'=> 'Petits gâteaux',
        ];

        $categorieActive = $request->query->get('categorie', '');
        $recherche       = trim($request->query->get('q', ''));

        $recettesFiltrees = array_filter($recettes, function ($r) use ($categorieActive, $recherche) {
            if ($categorieActive && $r['categorie'] !== $categorieActive) {
                return false;
            }
            if ($recherche && stripos($r['titre'], $recherche) === false && stripos($r['description'], $recherche) === false) {
                return false;
            }
            return true;
        });

        return $this->render('recettes/index.html.twig', [
            'recettes'        => array_values($recettesFiltrees),
            'categories'      => $categories,
            'categorieActive' => $categorieActive,
            'recherche'       => $recherche,
        ]);
    }
}
