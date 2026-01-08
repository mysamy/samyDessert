<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class LoginForm
{
    public string $action = '';
    public string $method = 'post';
    public string $id = 'login-form';
    public string $class = 'max-w-md space-y-6';

    public string $submitLabel = 'Se connecter';

    public ?string $emailValue = null;

    public ?string $emailError = null;
    public ?string $passwordError = null;
    public ?string $formError = null;

    public bool $rememberMe = false;

    public ?string $csrfToken = null;

    public function getHasAnyError(): bool
    {
        return (bool) ($this->formError || $this->emailError || $this->passwordError);
    }

    public function getErrorSummaryId(): string
    {
        return $this->id.'__error-summary';
    }
}
