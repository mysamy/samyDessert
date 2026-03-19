# docker/ — Configuration des containers

Contient les fichiers de configuration pour construire les images Docker du projet.

---

## Structure

```
docker/
├── php/
│   └── Dockerfile      # Image PHP-FPM 8.3 avec les extensions nécessaires
│
└── nginx/
    └── default.conf    # Configuration du serveur web nginx
```

---

## Le Dockerfile PHP (`docker/php/Dockerfile`)

Construit l'image PHP utilisée par le container `php` dans `docker-compose.yml`.

Ce qu'il installe :
- PHP 8.3 FPM (FastCGI Process Manager — sert les scripts PHP)
- Extensions PHP : `pdo_mysql` (BDD), `zip`, `intl`, `opcache`
- Composer (gestionnaire de dépendances PHP)
- OPcache configuré pour les performances

---

## La config nginx (`docker/nginx/default.conf`)

Configure le serveur web nginx pour servir une application Symfony :

- Écoute sur le port 80
- Sert les fichiers statiques directement (CSS, JS, images)
- Passe les requêtes PHP au container `php` via FastCGI (port 9000)
- Point d'entrée Symfony : `public/index.php`

---

## Les 5 containers (définis dans `docker-compose.yml`)

| Container | Image | Rôle |
|-----------|-------|------|
| `nginx` | nginx:alpine | Serveur web — reçoit les requêtes HTTP (port 8080) |
| `php` | Dockerfile local | Exécute PHP-FPM — traite les scripts Symfony |
| `mysql` | mysql:8.0 | Base de données MySQL (port 3306) |
| `adminer` | adminer | Interface web pour gérer la BDD (port 8081) |
| `assets` | même Dockerfile | Compile Tailwind + AssetMapper toutes les 10 secondes |

---

## Pourquoi deux containers nginx + php séparés ?

C'est l'architecture standard en production :
- **nginx** gère les connexions HTTP (léger, rapide pour les fichiers statiques)
- **php-fpm** exécute uniquement les scripts PHP (pool de processus optimisé)
- Ils communiquent via le protocole FastCGI sur le port 9000
