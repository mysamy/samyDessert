#!/bin/sh
# Script de démarrage exécuté par Railway au lancement du conteneur

# Arrêter immédiatement en cas d'erreur
set -e

# Marque les migrations déjà appliquées manuellement en base
echo "==> Synchronisation des versions de migration..."
php bin/console doctrine:migrations:version 'DoctrineMigrations\Version20260317141858' --add --no-interaction 2>/dev/null || true

# Applique les migrations Doctrine en attente
echo "==> Application des migrations..."
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

# Lance le serveur PHP intégré sur le port injecté par Railway
# Note : FrankenPHP ne fonctionne pas dans cette config Railway
# (le binaire log "server running" mais ne bind jamais le port → connection refused)
echo "==> Démarrage du serveur PHP sur le port ${PORT:-80}..."
exec php -S 0.0.0.0:${PORT:-80} -t public/
