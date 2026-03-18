<?php

namespace App\Service;

use App\Entity\Commande;
use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;

// Service de génération de factures PDF
class FactureService
{
    public function __construct(
        private Environment $twig,
    ) {}

    // Génère et retourne le contenu binaire du PDF de facture
    public function genererPdf(Commande $commande): string
    {
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);

        $html = $this->twig->render('pdf/facture.html.twig', [
            'commande' => $commande,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
