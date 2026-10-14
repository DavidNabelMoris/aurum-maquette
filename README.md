# Aurum · Maquette

Démo d'un site de rachat d'or et d'un espace pro (tableau de bord). PHP 8.2, HTML, CSS et JavaScript (modules ES), sans framework ni étape de build.

## Lancer le projet

```bash
C:\xampp\php\php.exe -S localhost:8000 -t public public/index.php
```

- Site : http://localhost:8000
- Espace pro : http://localhost:8000/admin (identifiant `admin`, mot de passe de démo `aurum-demo-2026`)

En production (Apache), la racine web est `public/` : le fichier `.htaccess` envoie toutes les requêtes vers `index.php`.

## Variables d'environnement

| Variable | Rôle |
| --- | --- |
| `APP_URL` | URL publique, utilisée pour les liens canoniques, le sitemap et l'image Open Graph |
| `APP_DEBUG=1` | Affiche les erreurs (développement uniquement) |
| `APP_FORCE_HTTPS=1` | Redirige vers HTTPS |
| `APP_KEY` | Clé de chiffrement (32 octets en base64). Sinon générée dans `storage/app.key` |
| `ADMIN_USERNAME`, `ADMIN_PASSWORD_HASH` | Compte de l'espace pro. Générer le hash : `php -r "echo password_hash('motdepasse', PASSWORD_DEFAULT);"` |
| `GTM_ID` | Google Tag Manager, chargé seulement après accord dans la bannière cookies |

## Structure

```
config/          app.php (site, menus, CDN), security.php (compte admin, limites)
data/            Contenu et données de démonstration (JSON)
docs/            Checklist avant mise en ligne
public/          Racine web : index.php (unique point d'entrée), assets, favicon, llms.txt
src/
  Controllers/   Site, SEO, authentification, espace pro, API
  Http/          Routeur
  Security/      Session, CSRF, limitation de débit, authentification, chiffrement, en-têtes
  Services/      Logique métier (entreprise, agences, tournées, cours, estimations)
  Support/       Journalisation
  routes.php     Toutes les routes
storage/         Données écrites par l'application : demandes chiffrées, journaux (ignoré par Git)
templates/       Vues : layouts/, partials/, pages/
```

## Routes

| Méthode | Chemin | Accès |
| --- | --- | --- |
| GET | `/`, `/a-propos`, `/mentions-legales`, `/confidentialite`, `/cgu` | Public |
| GET | `/robots.txt`, `/sitemap.xml` | Public |
| GET, POST | `/admin/login` | Public |
| GET | `/admin` | Connecté |
| POST | `/admin/logout` | Connecté |
| GET | `/api/stats?period=month\|week` | Connecté |
| POST | `/api/estimations` | Public, jeton CSRF |

## Ajouter une page

1. Ajouter la route dans `src/routes.php`.
2. Ajouter la méthode dans le contrôleur, avec son titre et sa description (`meta`).
3. Créer la vue dans `templates/pages/`.
4. Ajouter le chemin dans `SeoController::PUBLIC_PAGES` pour le sitemap.

## Sécurité

Voir [docs/PRE-LAUNCH.md](docs/PRE-LAUNCH.md) pour le détail de ce qui est en place et de ce qui reste à faire avant une mise en ligne.

Les cours, les tournées et les chiffres du tableau de bord sont fictifs.

Le hero utilise un moteur WebGL2 de particules (`public/assets/js/site/liquid-engine.js`), adapté de « Sculpture Hero » par guglielmogiannattasio.it. Sans WebGL2, l'image fixe s'affiche.
