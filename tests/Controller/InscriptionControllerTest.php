<?php

namespace App\Tests\Controller;

use App\Entity\Utilisateur;
use App\Factory\UtilisateurFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class InscriptionControllerTest extends WebTestCase
{
    use ResetDatabase, Factories;

    public function testGetInscription(): void
    {
        $client = static::createClient();
        $client->request('GET', '/inscription');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function testMotsDePasseDifferents(): void
    {
        $client = static::createClient();
        $client->request('POST', '/inscription', [
            'email'            => 'nouveau@test.com',
            'password'         => 'motdepasse123',
            'password_confirm' => 'autrechose456',
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'correspondent pas');
    }

    public function testMotsDePasseTropCourt(): void
    {
        $client = static::createClient();
        $client->request('POST', '/inscription', [
            'email'            => 'nouveau@test.com',
            'password'         => '1234',
            'password_confirm' => '1234',
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', '8 caractères');
    }

    public function testInscriptionValide(): void
    {
        $client = static::createClient();
        $client->request('POST', '/inscription', [
            'email'            => 'nouveau@test.com',
            'password'         => 'motdepasse123',
            'password_confirm' => 'motdepasse123',
            'nom'              => 'Dupont',
            'prenom'           => 'Jean',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'nouveau@test.com');

        $em   = $client->getContainer()->get(EntityManagerInterface::class);
        $user = $em->getRepository(Utilisateur::class)->findOneBy(['email' => 'nouveau@test.com']);
        $this->assertNotNull($user);
        $this->assertFalse($user->isVerified());
    }

    public function testEmailDejaUtilise(): void
    {
        $client = static::createClient();
        UtilisateurFactory::createOne(['email' => 'existant@test.com']);

        $client->request('POST', '/inscription', [
            'email'            => 'existant@test.com',
            'password'         => 'motdepasse123',
            'password_confirm' => 'motdepasse123',
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'déjà utilisée');
    }
}
