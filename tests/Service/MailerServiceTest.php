<?php

namespace App\Tests\Service;

use App\Service\FactureService;
use App\Service\MailerService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailerServiceTest extends TestCase
{
    private MailerService $service;
    private MailerInterface $mailerMock;

    protected function setUp(): void
    {
        $this->mailerMock = $this->createMock(MailerInterface::class);
        $twig             = $this->createMock(Environment::class);
        $facture          = $this->createMock(FactureService::class);

        $this->service = new MailerService(
            $this->mailerMock,
            $twig,
            $facture,
            'noreply@samydessert.fr',
        );
    }

    public function testEnvoyerMessageContactAppelleMailer(): void
    {
        $this->mailerMock
            ->expects($this->once())
            ->method('send');

        $this->service->envoyerMessageContact('Jean', 'jean@example.com', 'Question', 'Bonjour');
    }

    public function testEnvoyerMessageContactSujetContientNomEtSujet(): void
    {
        $emailEnvoye = null;

        $this->mailerMock
            ->expects($this->once())
            ->method('send')
            ->willReturnCallback(function (Email $email) use (&$emailEnvoye) {
                $emailEnvoye = $email;
            });

        $this->service->envoyerMessageContact('Jean Dupont', 'jean@example.com', 'Ma question', 'Texte');

        $this->assertNotNull($emailEnvoye);
        $this->assertStringContainsString('Jean Dupont', $emailEnvoye->getSubject());
        $this->assertStringContainsString('Ma question', $emailEnvoye->getSubject());
    }

    public function testEnvoyerMessageContactDestinataire(): void
    {
        $emailEnvoye = null;

        $this->mailerMock
            ->expects($this->once())
            ->method('send')
            ->willReturnCallback(function (Email $email) use (&$emailEnvoye) {
                $emailEnvoye = $email;
            });

        $this->service->envoyerMessageContact('Jean', 'jean@example.com', 'Sujet', 'Message');

        // Le message de contact est envoyé à l'adresse de l'admin (mailerFrom)
        $to = array_map(fn($a) => $a->getAddress(), $emailEnvoye->getTo());
        $this->assertContains('noreply@samydessert.fr', $to);
    }

    public function testEnvoyerMessageContactReplyTo(): void
    {
        $emailEnvoye = null;

        $this->mailerMock
            ->method('send')
            ->willReturnCallback(function (Email $email) use (&$emailEnvoye) {
                $emailEnvoye = $email;
            });

        $this->service->envoyerMessageContact('Jean', 'jean@example.com', 'Sujet', 'Message');

        // Le reply-to pointe vers l'expéditeur du formulaire
        $replyTo = array_map(fn($a) => $a->getAddress(), $emailEnvoye->getReplyTo());
        $this->assertContains('jean@example.com', $replyTo);
    }

    public function testEnvoyerMessageContactCorpsContientMessage(): void
    {
        $emailEnvoye = null;

        $this->mailerMock
            ->method('send')
            ->willReturnCallback(function (Email $email) use (&$emailEnvoye) {
                $emailEnvoye = $email;
            });

        $this->service->envoyerMessageContact('Jean', 'jean@example.com', 'Sujet', 'Mon message spécial');

        $this->assertStringContainsString('Mon message spécial', $emailEnvoye->getHtmlBody());
    }
}
