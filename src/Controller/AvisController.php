<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Utilisateur;
use App\Repository\AvisRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// Contrôleur des avis : soumission et modification d'un avis sur un produit
final class AvisController extends AbstractController
{
    #[Route('/produits/{slug}/avis', name: 'app_avis_submit', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function submit(
        string $slug,
        Request $request,
        ProduitRepository $produitRepo,
        AvisRepository $avisRepo,
        EntityManagerInterface $em,
    ): Response {
        $produit = $produitRepo->findOneBy(['slug' => $slug]);
        if (!$produit) {
            throw $this->createNotFoundException('Produit introuvable.');
        }

        $user = $this->getUser();
        assert($user instanceof Utilisateur);

        // Validation CSRF
        if (!$this->isCsrfTokenValid('avis_' . $produit->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token invalide.');
            return $this->redirectToRoute('app_produit_show', ['slug' => $slug]);
        }

        // Validation de la note (1-5)
        $note = (int) $request->request->get('note', 0);
        if ($note < 1 || $note > 5) {
            $this->addFlash('error', 'Veuillez sélectionner une note entre 1 et 5.');
            return $this->redirectToRoute('app_produit_show', ['slug' => $slug]);
        }

        $commentaire = trim($request->request->get('commentaire', ''));

        // Créer ou mettre à jour l'avis existant
        $avis = $avisRepo->findOneByUserAndProduit($user, $produit);
        if (!$avis) {
            $avis = new Avis();
            $avis->setUtilisateur($user);
            $avis->setProduit($produit);
            $em->persist($avis);
        }

        $avis->setNote($note);
        $avis->setCommentaire($commentaire !== '' ? $commentaire : null);
        $avis->setIsValide(true);

        $em->flush();

        $this->addFlash('success', 'Votre avis a bien été enregistré.');
        return $this->redirectToRoute('app_produit_show', ['slug' => $slug]);
    }
}
