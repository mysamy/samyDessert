#!/bin/sh
# Script de démarrage exécuté par Railway au lancement du conteneur

# Arrêter immédiatement en cas d'erreur
set -e

# Synchronise le schéma de la base de données avec les entités Doctrine
# (crée ou modifie les tables sans passer par les migrations)
echo "==> Mise à jour du schéma de base de données..."
php bin/console doctrine:schema:update --force --no-interaction

# Lance le serveur PHP intégré sur le port injecté par Railway
# Note : FrankenPHP ne fonctionne pas dans cette config Railway
# (le binaire log "server running" mais ne bind jamais le port → connection refused)
echo "==> Démarrage du serveur PHP sur le port ${PORT:-80}..."
exec php -S 0.0.0.0:${PORT:-80} -t public/
