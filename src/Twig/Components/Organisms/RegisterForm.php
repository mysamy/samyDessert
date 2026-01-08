<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class RegisterForm
{
    public string $action = '';
    public string $method = 'post';
    public string $id = 'register-form';
    public string $class = 'max-w-md space-y-6';

    public string $submitLabel = 'Créer mon compte';

    public ?string $emailValue = null;
    public ?string $emailError = null;

    public ?string $passwordError = null;
    public ?string $confirmPasswordError = null;

    public ?string $formError = null;

    public ?string $csrfToken = null;

    public function getHasAnyError(): bool
    {
        return (bool) ($this->formError || $this->emailError || $this->passwordError || $this->confirmPasswordError);
    }

    public function getErrorSummaryId(): string
    {
        return $this->id.'__error-summary';
    }
}
