<?php

namespace App\Enum;

enum StatutCommande: string
{
    case EnAttente  = 'en_attente';
    case Confirmee  = 'confirmee';
    case Livree     = 'livree';
    case Annulee    = 'annulee';
}
