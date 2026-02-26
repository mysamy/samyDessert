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

    public string $formError = '';
    public string $csrfToken = '';

    public string $firstNameValue = '';
    public string $lastNameValue = '';
    public string $companyValue = '';

    public string $address1Value = '';
    public string $address2Value = '';
    public string $postalCodeValue = '';
    public string $cityValue = '';
    public string $countryValue = 'FR';
    public string $phoneValue = '';

    public string $notesValue = '';

    public string $firstNameError = '';
    public string $lastNameError = '';
    public string $address1Error = '';
    public string $postalCodeError = '';
    public string $cityError = '';
    public string $countryError = '';
    public string $phoneError = '';

    public array $countries = [
        ['value' => 'FR', 'label' => 'France'],
        ['value' => 'BE', 'label' => 'Belgique'],
        ['value' => 'CH', 'label' => 'Suisse'],
        ['value' => 'LU', 'label' => 'Luxembourg'],
    ];

    public function getHasAnyError(): bool
    {
        return $this->formError !== ''
            || $this->firstNameError !== ''
            || $this->lastNameError !== ''
            || $this->address1Error !== ''
            || $this->postalCodeError !== ''
            || $this->cityError !== ''
            || $this->countryError !== ''
            || $this->phoneError !== '';
    }

    public function getErrorSummaryId(): string
    {
        return $this->id.'__error-summary';
    }
}
