# config/ — Configuration Symfony

Contient tous les fichiers de configuration de l'application Symfony.

---

## Structure

```
config/
├── bundles.php         # Liste des bundles (extensions) Symfony activés
├── preload.php         # Préchargement PHP pour les performances (OPcache)
├── routes.yaml         # Routes globales (ex: /login, /_profiler)
├── services.yaml       # Déclaration des services et injection de dépendances
│
├── packages/           # Configuration de chaque bundle installé
│   ├── doctrine.yaml           # Configuration BDD et ORM
│   ├── security.yaml           # Firewall, login, rôles, hachage des mots de passe
│   ├── twig.yaml               # Options Twig (variables globales, chemins...)
│   ├── mailer.yaml             # Configuration de l'envoi d'emails
│   ├── asset_mapper.yaml       # Configuration Symfony AssetMapper
│   ├── tailwind.yaml           # Configuration symfonycasts/tailwind-bundle
│   └── ...
│
└── routes/             # Routes ajoutées par les bundles
    ├── security.yaml           # Routes de login/logout générées par Symfony Security
    └── ...
```

---

## Fichiers importants

### `services.yaml`
Déclare comment Symfony instancie les services et injecte les dépendances.

```yaml
# Exemple : injection du paramètre MAILER_FROM dans MailerService
App\Service\MailerService:
    arguments:
        $mailerFrom: '%env(MAILER_FROM)%'
```

### `packages/security.yaml`
Configure toute la sécurité du site :
- Hachage des mots de passe (`bcrypt`)
- Firewall principal (quelle page nécessite d'être connecté)
- Page de login (`/connexion`)
- Page de logout (`/deconnexion`)
- Redirection après connexion
- Le `UserChecker` (vérifie que l'email est confirmé)

### `packages/doctrine.yaml`
Configure la connexion à MySQL et l'ORM Doctrine (mapping, cache...).

---

## Règle importante

Ne jamais mettre de secrets (mots de passe, clés API) dans ces fichiers.
Utiliser les variables d'environnement définies dans `.env.local` :

```yaml
# ✅ Correct — lit depuis l'environnement
DATABASE_URL: '%env(DATABASE_URL)%'

# ❌ Interdit — secret en clair dans un fichier committé
DATABASE_URL: 'mysql://root:monmotdepasse@localhost/mabd'
```
