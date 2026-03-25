# samyDessert — Mémoire

## Règles mémoire
- **TOUJOURS écrire dans `.claude/memory/MEMORY.md` (repo git), JAMAIS dans le dossier local hors-repo**
- Rappeler à l'utilisateur de commit + push la mémoire en fin de session
- Résumer chaque session en fin de conversation

## Docker — points non évidents
- `asset-map:compile` est **interdit en dev** → crée `public/assets/` qui empêche Symfony de servir les assets dynamiquement
- Si carousel/JS cassé après Docker : `docker compose exec php rm -rf public/assets`
- TODO prod : supprimer service `assets`, ajouter `RUN php bin/console tailwind:build && php bin/console asset-map:compile` dans Dockerfile

## Historique des sessions

### 2026-03-11 — Configuration Docker
- Ajout service `assets` pour recompiler Tailwind (watch inotify non supporté Windows+Docker)
- Fix : `asset-map:compile` cassait les assets en mode dev

### 2026-03-25 — Fix mémoire + carousel Docker
- Mémoire n'était pas mise à jour depuis le 11 mars → Claude écrivait dans le dossier local hors-repo
- Fix : règle ajoutée pour toujours écrire dans le repo git
- Carousel cassé : `asset-map:compile` dans le service assets → retiré du docker-compose
- Nettoyage MEMORY.md : suppression des doublons avec CLAUDE.md pour économiser les tokens
- **TODO 2026-03-26** : Vérifier que le test mémoire a marché après pull sur l'autre PC