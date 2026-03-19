<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\Recette;
use App\Enum\Difficulte;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// Fixtures : insère des données de test dans la base de données
// Lancer avec : php bin/console doctrine:fixtures:load
class AppFixtures extends Fixture
{
    // Injection du service de hashage de mot de passe
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // --- Catégories ---
        $categories = [];
        foreach ([
            'tartes'       => 'Tartes',
            'choux'        => 'Choux & Éclairs',
            'petits-fours' => 'Petits fours',
            'entremets'    => 'Entremets',
        ] as $slug => $nom) {
            $cat = new Categorie();
            $cat->setNom($nom);
            $cat->setSlug($slug);
            $manager->persist($cat);
            $categories[$slug] = $cat;
        }

        // --- Produits ---
        $produits = [
            // Tartes
            ['nom' => 'Tarte aux fraises',        'prix' => '6.50', 'categorie' => 'tartes',       'image' => 'https://images.unsplash.com/photo-1464305795204-6f5bbfc7fb81?w=600&q=80', 'description' => 'Tarte fraîche garnie de fraises de saison sur crème pâtissière vanille.'],
            ['nom' => 'Tarte au citron meringuée', 'prix' => '7.00', 'categorie' => 'tartes',       'image' => 'https://images.unsplash.com/photo-1765992314341-48ba688f8d49?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8dGFydGUlMjBtZXJpbmd1JUMzJUE5ZXxlbnwwfHwwfHx8MA%3D%3D', 'description' => 'Tarte acidulée avec une meringue légère et croustillante.'],
            ['nom' => 'Tarte aux framboises',      'prix' => '6.50', 'categorie' => 'tartes',       'image' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=600&q=80', 'description' => 'Fond de tarte croustillant, crème d\'amandes et framboises fraîches.'],
            ['nom' => 'Tarte tatin',               'prix' => '6.00', 'categorie' => 'tartes',       'image' => 'https://images.unsplash.com/photo-1621955964441-c173e01c135b?w=600&q=80', 'description' => 'Tarte renversée aux pommes caramélisées, servie tiède avec crème fraîche.'],
            ['nom' => 'Tarte aux myrtilles',       'prix' => '6.50', 'categorie' => 'tartes',       'image' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=600&q=80', 'description' => 'Fond sablé, crème d\'amandes et myrtilles fraîches du marché.'],
            // Choux
            ['nom' => 'Éclair au chocolat',        'prix' => '4.00', 'categorie' => 'choux',        'image' => 'https://images.unsplash.com/photo-1602351447937-745cb720612f?w=600&q=80', 'description' => 'Pâte à choux garnie d\'une crème pâtissière au chocolat noir.'],
            ['nom' => 'Paris-Brest',               'prix' => '5.50', 'categorie' => 'choux',        'image' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=600&q=80', 'description' => 'Couronne de pâte à choux garnie d\'une crème mousseline praliné.'],
            ['nom' => 'Religieuse café',           'prix' => '4.50', 'categorie' => 'choux',        'image' => 'https://images.unsplash.com/photo-1517244683847-7456b63c5969?w=600&q=80', 'description' => 'Double chou à la crème café, glaçage fondant.'],
            ['nom' => 'Chouquettes (x10)',         'prix' => '3.50', 'categorie' => 'choux',        'image' => 'https://images.unsplash.com/photo-1550617931-e17a7b70dce2?w=600&q=80', 'description' => 'Petits choux légers parsemés de sucre perlé, à croquer sans modération.'],
            ['nom' => 'Saint-Honoré',              'prix' => '8.00', 'categorie' => 'choux',        'image' => 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=600&q=80', 'description' => 'Couronne de pâte feuilletée, choux caramélisés et crème Chiboust.'],
            // Petits fours
            ['nom' => 'Macarons (x6)',             'prix' => '9.00', 'categorie' => 'petits-fours', 'image' => 'https://images.unsplash.com/photo-1569864358642-9d1684040f43?w=600&q=80', 'description' => 'Assortiment de 6 macarons aux parfums variés.'],
            ['nom' => 'Crème brûlée',              'prix' => '5.50', 'categorie' => 'petits-fours', 'image' => 'https://images.unsplash.com/photo-1470124182917-cc6e71b22ecc?w=600&q=80', 'description' => 'Crème vanille onctueuse avec une fine croûte de caramel.'],
            ['nom' => 'Mille-feuille',             'prix' => '6.00', 'categorie' => 'petits-fours', 'image' => 'https://images.unsplash.com/photo-1608039755401-742074f0548d?w=600&q=80', 'description' => 'Feuilletage croustillant, crème pâtissière vanille et glaçage royal.'],
            ['nom' => 'Financiers (x4)',           'prix' => '4.50', 'categorie' => 'petits-fours', 'image' => 'https://images.unsplash.com/photo-1519676867240-f03562e64548?w=600&q=80', 'description' => 'Petits gâteaux moelleux au beurre noisette et poudre d\'amande.'],
            ['nom' => 'Madeleine au beurre (x6)',  'prix' => '5.00', 'categorie' => 'petits-fours', 'image' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=600&q=80', 'description' => 'Les vraies madeleines de Commercy, moelleuses avec leur bosse caractéristique.'],
            // Entremets
            ['nom' => 'Mousse au chocolat',        'prix' => '5.00', 'categorie' => 'entremets',    'image' => 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=600&q=80', 'description' => 'Mousse aérienne au chocolat noir, à préparer la veille pour un résultat optimal.'],
            ['nom' => 'Charlotte aux framboises',  'prix' => '7.50', 'categorie' => 'entremets',    'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&q=80', 'description' => 'Biscuits à la cuillère et mousse framboise, élégante et fraîche.'],
            ['nom' => 'Fondant au chocolat',       'prix' => '5.50', 'categorie' => 'entremets',    'image' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=600&q=80', 'description' => 'Fondant au cœur coulant, à servir tiède avec une boule de glace vanille.'],
            ['nom' => 'Tiramisu',                  'prix' => '5.00', 'categorie' => 'entremets',    'image' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=600&q=80', 'description' => 'Mascarpone, biscuits imbibés de café et cacao — un classique italien.'],
            ['nom' => 'Opéra',                     'prix' => '7.00', 'categorie' => 'entremets',    'image' => 'https://images.unsplash.com/photo-1534432182912-63863115e106?w=600&q=80', 'description' => 'Biscuit joconde, crème au beurre café et ganache chocolat en couches alternées.'],
        ];

        $produitEntites = [];
        foreach ($produits as $data) {
            $produit = new Produit();
            $produit->setNom($data['nom']);
            $produit->setPrix($data['prix']);
            $produit->setDescription($data['description']);
            $produit->setImageSrc($data['image']);
            $produit->setDisponible(true);
            $produit->setCategorie($categories[$data['categorie']]);
            $manager->persist($produit);
            $produitEntites[$data['nom']] = $produit;
        }

        // --- Recettes ---
        $recettes = [
            [
                'titre'      => 'Tarte au citron meringuée',
                'description'=> 'Une tarte acidulée avec une meringue légère et croustillante, parfaite pour les amateurs de citron.',
                'contenu'    => "1. Préparer la pâte sablée et la cuire à blanc.\n2. Réaliser le lemon curd avec jus de citron, œufs, sucre et beurre.\n3. Verser sur le fond de tarte et laisser refroidir.\n4. Monter les blancs en neige avec le sucre pour la meringue.\n5. Dorer au chalumeau.",
                'duree'      => 90,
                'difficulte' => Difficulte::Moyen,
                'produit'    => 'Tarte au citron meringuée',
            ],
            [
                'titre'      => 'Éclair au chocolat',
                'description'=> 'La pâte à choux maison garnie d\'une crème pâtissière au chocolat noir.',
                'contenu'    => "1. Préparer la pâte à choux (eau, beurre, farine, œufs).\n2. Pocher et cuire 25 min à 180°C.\n3. Réaliser la crème pâtissière au chocolat noir.\n4. Garnir les éclairs à la poche.\n5. Glacer au fondant chocolat.",
                'duree'      => 120,
                'difficulte' => Difficulte::Difficile,
                'produit'    => 'Éclair au chocolat',
            ],
            [
                'titre'      => 'Macarons à la framboise',
                'description'=> 'Des coques légères et croquantes garnies d\'une ganache framboise acidulée.',
                'contenu'    => "1. Tamiser la poudre d'amande et le sucre glace.\n2. Monter les blancs avec le sucre (meringue italienne).\n3. Macaronner et pocher sur plaque.\n4. Laisser croûter 30 min puis cuire 13 min à 150°C.\n5. Garnir de ganache framboise.",
                'duree'      => 150,
                'difficulte' => Difficulte::Difficile,
                'produit'    => null,
            ],
            [
                'titre'      => 'Tarte aux fraises',
                'description'=> 'Une tarte fraîche avec une crème pâtissière vanille et des fraises de saison.',
                'contenu'    => "1. Préparer et cuire la pâte sablée à blanc.\n2. Réaliser la crème pâtissière vanille.\n3. Laisser refroidir et étaler sur le fond de tarte.\n4. Disposer les fraises coupées en éventail.\n5. Napper de gelée de fraise pour la brillance.",
                'duree'      => 60,
                'difficulte' => Difficulte::Facile,
                'produit'    => 'Tarte aux fraises',
            ],
        ];

        foreach ($recettes as $data) {
            $recette = new Recette();
            $recette->setTitre($data['titre']);
            $recette->setDescription($data['description']);
            $recette->setContenu($data['contenu']);
            $recette->setDuree($data['duree']);
            $recette->setDifficulte($data['difficulte']);
            if ($data['produit'] && isset($produitEntites[$data['produit']])) {
                $recette->setProduit($produitEntites[$data['produit']]);
            }
            $manager->persist($recette);
        }
        // --- Utilisateur de test ---
        $user = new Utilisateur();
        $user->setEmail('test@test.com');
        $user->setPassword($this->hasher->hashPassword($user, 'password123'));
        $user->setIsVerified(true);
        $manager->persist($user);

        $admin = new Utilisateur();
        $admin->setEmail('samy@admin.com');
        $admin->setPassword($this->hasher->hashPassword($admin, 'password123'));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsVerified(true);
        $manager->persist($admin);

        // Envoie toutes les données en base en une seule fois
        $manager->flush();
    }
}
