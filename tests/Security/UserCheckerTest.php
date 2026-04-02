<?php

namespace App\Tests\Security;

use App\Entity\Utilisateur;
use App\Security\UserChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class UserCheckerTest extends TestCase
{
    private UserChecker $checker;

    protected function setUp(): void
    {
        $this->checker = new UserChecker();
    }

    public function testCompteVerifiePasseSansErreur(): void
    {
        $user = new Utilisateur();
        $user->setEmail('test@test.com');
        $user->setIsVerified(true);

        // Aucune exception ne doit être levée
        $this->checker->checkPreAuth($user);
        $this->assertTrue(true); // Si on arrive ici, le test passe
    }

    public function testCompteNonVerifieLeveUneException(): void
    {
        $user = new Utilisateur();
        $user->setEmail('test@test.com');
        $user->setIsVerified(false);

        $this->expectException(CustomUserMessageAccountStatusException::class);
        $this->checker->checkPreAuth($user);
    }

    public function testMessageErreurCompteNonVerifie(): void
    {
        $user = new Utilisateur();
        $user->setIsVerified(false);

        try {
            $this->checker->checkPreAuth($user);
            $this->fail('Exception attendue non levée');
        } catch (CustomUserMessageAccountStatusException $e) {
            $this->assertStringContainsString('activé', $e->getMessage());
        }
    }

    public function testCheckPostAuthNeFaitRien(): void
    {
        $user = new Utilisateur();
        $user->setIsVerified(false); // Même non vérifié, postAuth ne fait rien

        $this->checker->checkPostAuth($user);
        $this->assertTrue(true);
    }
}
