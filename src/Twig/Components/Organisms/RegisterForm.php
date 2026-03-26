<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class RegisterForm
{
    public string $action = '';
    public string $id = 'register-form';
    public string $class = 'max-w-md space-y-6';

    public string $submitLabel = 'Créer mon compte';

    public string $emailValue = '';
    public string $emailError = '';

    public string $passwordError = '';
    public string $confirmPasswordError = '';

    public string $formError = '';

    public string $csrfToken = '';

    public function getHasAnyError(): bool
    {
        return $this->formError !== ''
            || $this->emailError !== ''
            || $this->passwordError !== ''
            || $this->confirmPasswordError !== '';
    }

    public function getErrorSummaryId(): string
    {
        return $this->id.'__error-summary';
    }
}
