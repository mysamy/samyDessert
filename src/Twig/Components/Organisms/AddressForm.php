<?php

namespace App\Twig\Components\Organisms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class AddressForm
{
    public string $action = '';
    public string $method = 'post';
    public string $id = 'address-form';
    public string $class = 'max-w-xl space-y-6';

    public string $legend = 'Adresse';
    public string $submitLabel = 'Enregistrer';

    public ?string $formError = null;

    public ?string $csrfToken = null;

    public ?string $firstNameValue = null;
    public ?string $lastNameValue = null;
    public ?string $companyValue = null;

    public ?string $address1Value = null;
    public ?string $address2Value = null;
    public ?string $postalCodeValue = null;
    public ?string $cityValue = null;
    public ?string $countryValue = 'FR';
    public ?string $phoneValue = null;

    public ?string $notesValue = null;

    public ?string $firstNameError = null;
    public ?string $lastNameError = null;
    public ?string $address1Error = null;
    public ?string $postalCodeError = null;
    public ?string $cityError = null;
    public ?string $countryError = null;
    public ?string $phoneError = null;

    public array $countries = [
        ['value' => 'FR', 'label' => 'France'],
        ['value' => 'BE', 'label' => 'Belgique'],
        ['value' => 'CH', 'label' => 'Suisse'],
        ['value' => 'LU', 'label' => 'Luxembourg'],
    ];

    public function getHasAnyError(): bool
    {
        return (bool) (
            $this->formError ||
            $this->firstNameError ||
            $this->lastNameError ||
            $this->address1Error ||
            $this->postalCodeError ||
            $this->cityError ||
            $this->countryError ||
            $this->phoneError
        );
    }

    public function getErrorSummaryId(): string
    {
        return $this->id.'__error-summary';
    }
}
