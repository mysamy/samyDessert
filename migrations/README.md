# migrations/ — Scripts SQL Doctrine

Contient les fichiers de migration générés automatiquement par Doctrine.

---

## C'est quoi une migration ?

Une migration est un script PHP qui contient le SQL nécessaire pour faire évoluer
la structure de la base de données (créer une table, ajouter une colonne, etc.).

Chaque migration a deux méthodes :
- `up()` — applique le changement
- `down()` — annule le changement (rollback)

---

## Workflow typique

```bash
# 1. Tu modifies une entité PHP (ex: tu ajoutes une propriété à Produit.php)

# 2. Doctrine compare l'entité avec la BDD et génère le SQL nécessaire
docker compose exec php php bin/console make:migration

# 3. Tu appliques la migration (exécute le SQL en base)
docker compose exec php php bin/console doctrine:migrations:migrate
```

---

## Règles importantes

- **Ne jamais modifier** un fichier de migration déjà appliqué en production.
- Si tu as fait une erreur, crée une **nouvelle migration** qui corrige le tir.
- Les migrations sont committées dans Git — tous les membres de l'équipe peuvent
  mettre leur BDD à jour avec `doctrine:migrations:migrate`.
- Le container Docker `init` applique les migrations automatiquement au démarrage.

---

## Voir l'état des migrations

```bash
# Voir quelles migrations sont appliquées ou non
docker compose exec php php bin/console doctrine:migrations:status
```
