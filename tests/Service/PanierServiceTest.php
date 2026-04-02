<?php

namespace App\Tests\Service;

use App\Repository\ProduitRepository;
use App\Service\PanierService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class PanierServiceTest extends TestCase
{
    private PanierService $panier;
    private Session $session;

    protected function setUp(): void
    {
        // Session en mémoire — pas de vraie base de données, pas de HTTP
        $this->session = new Session(new MockArraySessionStorage());

        $requestStack = new RequestStack();
        $request = new Request();
        $request->setSession($this->session);
        $requestStack->push($request);

        // ProduitRepository non utilisé dans les tests de session pure
        $repo = $this->createMock(ProduitRepository::class);

        $this->panier = new PanierService($requestStack, $repo);
    }

    public function testPanierVideParDefaut(): void
    {
        $this->assertSame(0, $this->panier->getNombreArticles());
    }

    public function testAjouterUnProduit(): void
    {
        $this->panier->ajouter(1);

        $this->assertSame(1, $this->panier->getNombreArticles());
        $this->assertSame(1, $this->panier->getQuantitePourProduit(1));
    }

    public function testAjouterPlusieursQuantites(): void
    {
        $this->panier->ajouter(1);
        $this->panier->ajouter(1);
        $this->panier->ajouter(1);

        $this->assertSame(3, $this->panier->getQuantitePourProduit(1));
        $this->assertSame(3, $this->panier->getNombreArticles());
    }

    public function testAjouterPlusieursProduitsDifferents(): void
    {
        $this->panier->ajouter(1);
        $this->panier->ajouter(2);
        $this->panier->ajouter(2);

        $this->assertSame(1, $this->panier->getQuantitePourProduit(1));
        $this->assertSame(2, $this->panier->getQuantitePourProduit(2));
        $this->assertSame(3, $this->panier->getNombreArticles());
    }

    public function testRetirerDiminueLaQuantite(): void
    {
        $this->panier->ajouter(1);
        $this->panier->ajouter(1);
        $this->panier->retirer(1);

        $this->assertSame(1, $this->panier->getQuantitePourProduit(1));
    }

    public function testRetirerSupprimeLaLigneSiQuantiteZero(): void
    {
        $this->panier->ajouter(1);
        $this->panier->retirer(1);

        $this->assertSame(0, $this->panier->getQuantitePourProduit(1));
        $this->assertSame(0, $this->panier->getNombreArticles());
    }

    public function testRetirerUnProduitAbsentNeFaitRien(): void
    {
        $this->panier->retirer(99);

        $this->assertSame(0, $this->panier->getNombreArticles());
    }

    public function testSupprimerSupprimeLeProduiPeuImporteQuantite(): void
    {
        $this->panier->ajouter(1);
        $this->panier->ajouter(1);
        $this->panier->ajouter(1);
        $this->panier->supprimer(1);

        $this->assertSame(0, $this->panier->getQuantitePourProduit(1));
        $this->assertSame(0, $this->panier->getNombreArticles());
    }

    public function testViderVideTout(): void
    {
        $this->panier->ajouter(1);
        $this->panier->ajouter(2);
        $this->panier->vider();

        $this->assertSame(0, $this->panier->getNombreArticles());
    }
}
