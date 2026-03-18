<?php

namespace App\Controller\Admin;

use App\Repository\CommandeRepository;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class CalendrierController extends AbstractController
{
    #[Route('/admin/calendrier', name: 'admin_calendrier')]
    public function index(): Response
    {
        return $this->render('admin/calendrier.html.twig');
    }

    // Retourne les commandes comme événements JSON pour FullCalendar
    #[Route('/admin/calendrier/events', name: 'admin_calendrier_events')]
    public function events(Request $request, CommandeRepository $commandeRepository): JsonResponse
    {
        $start = $request->query->get('start');
        $end   = $request->query->get('end');

        $qb = $commandeRepository->createQueryBuilder('c')
            ->join('c.utilisateur', 'u')
            ->select('c', 'u');

        if ($start) {
            $qb->andWhere('c.dateCommande >= :start')
               ->setParameter('start', new \DateTime($start));
        }
        if ($end) {
            $qb->andWhere('c.dateCommande <= :end')
               ->setParameter('end', new \DateTime($end));
        }

        $commandes = $qb->getQuery()->getResult();

        $events = [];
        foreach ($commandes as $commande) {
            $statut = $commande->getStatut()->value;
            $color = match ($statut) {
                'en_attente' => '#f59e0b',
                'confirmee'  => '#22c55e',
                'livree'     => '#3b82f6',
                'annulee'    => '#ef4444',
                default      => '#6b7280',
            };

            $events[] = [
                'id'              => $commande->getId(),
                'title'           => ($commande->getReference() ?? '#' . $commande->getId())
                    . ' — ' . ($commande->getUtilisateur()->getPrenom() ?? '')
                    . ' ' . ($commande->getUtilisateur()->getNom() ?? $commande->getUtilisateur()->getEmail()),
                'start'           => $commande->getDateCommande()->format('Y-m-d\TH:i:s'),
                'backgroundColor' => $color,
                'borderColor'     => $color,
                'extendedProps'   => [
                    'total'  => $commande->getTotal(),
                    'statut' => $statut,
                ],
            ];
        }

        return new JsonResponse($events);
    }
}
