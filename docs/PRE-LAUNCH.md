# Checklist avant mise en ligne

État au 14/10/2026. Légende : ✅ en place et testé · 🔧 à faire avant la production · ➖ sans objet (la fonctionnalité n'existe pas dans le projet).

## 1. À faire avant la production

1. Changer le mot de passe admin (`ADMIN_PASSWORD_HASH`) et définir `APP_KEY`, `APP_URL`, `APP_FORCE_HTTPS=1`.
2. Activer HTTPS sur le serveur, puis décommenter la redirection dans `public/.htaccess`.
3. Compléter les mentions légales, la politique de confidentialité et les CGU (éléments entre crochets) et les faire valider.
4. Renseigner la vraie adresse et l'e-mail de contact dans `config/app.php`.
5. Brancher les vraies données (cours des métaux, tournées, agences) à la place des fichiers de démonstration.
6. Déclarer le site dans Google Search Console et envoyer `sitemap.xml`.
7. Renseigner `GTM_ID` si une mesure d'audience est souhaitée.
8. Vérifier que `storage/` n'est pas servi par le serveur web (il est hors de `public/`) et qu'il est sauvegardé.

## 2. Sécurité et backend

| Contrôle | État | Détail |
| --- | --- | --- |
| HSTS | ✅ | Envoyé dès que la requête est en HTTPS (`SecurityHeaders`) |
| Forcer HTTPS | 🔧 | Prévu (`APP_FORCE_HTTPS`, `.htaccess`), à activer avec le certificat |
| En-têtes de sécurité | ✅ | CSP stricte, X-Frame-Options, nosniff, Referrer-Policy, Permissions-Policy, COOP ; `X-Powered-By` retiré |
| Jetons CSRF | ✅ | Formulaire d'estimation (en-tête `X-CSRF-Token`), connexion, déconnexion ; contrôle de l'en-tête `Origin` |
| Cookies de session sécurisés | ✅ | HttpOnly, SameSite=Lax, Secure en HTTPS, `use_strict_mode` |
| Authentification côté serveur | ✅ | `/admin` et `/api/stats` protégés par le routeur, expiration après 30 min d'inactivité |
| Route admin par défaut non protégée | ✅ | Plus aucune route admin accessible sans connexion (testé : 303 vers la connexion, 401 sur l'API) |
| Hachage des mots de passe | ✅ | `password_hash` / `password_verify` (bcrypt) |
| Blocage après échecs de connexion | ✅ | 5 essais par IP et par identifiant sur 15 min |
| Limitation de débit connexion | ✅ | Idem |
| Limitation de débit formulaire | ✅ | 5 demandes par IP sur 10 min (429 + `Retry-After`) |
| Énumération d'utilisateurs | ✅ | Message identique et même temps de réponse pour un identifiant inconnu |
| Nouvel identifiant de session à la connexion | ✅ | `session_regenerate_id(true)` |
| Protection anti-robots | ✅ | Champ piège + délai minimum de 3 s entre l'affichage et l'envoi |
| Validation côté serveur | ✅ | Toutes les entrées revalidées en PHP, listes blanches pour les choix |
| Nettoyage avant enregistrement | ✅ | Caractères de contrôle retirés, espaces normalisés, longueurs plafonnées |
| Falsification de champs | ✅ | Seuls les champs attendus sont conservés (testé avec `role` et `price` injectés : ignorés) |
| Échappement à l'affichage | ✅ | `e()` sur toutes les sorties ; JSON-LD encodé avec `JSON_HEX_TAG` |
| Taille des requêtes | ✅ | 16 Ko maximum (413), JSON obligatoire (415) |
| Réponses d'API minimales | ✅ | Le formulaire ne renvoie que la référence |
| CORS | ✅ | Aucun en-tête CORS : l'API n'est utilisable que depuis le site |
| Listage des répertoires | ✅ | `Options -Indexes` ; code, config et données hors de la racine web (testé : 404) |
| Traces d'erreur | ✅ | Erreurs masquées hors debug, page 500 et JSON génériques |
| Erreurs non gérées | ✅ | Gestionnaire global, avertissements PHP convertis en exceptions et journalisés |
| Panne du stockage | ✅ | Testé (fichier en lecture seule) : 500 propre, message clair dans le formulaire |
| Journal de sécurité | ✅ | `storage/logs/security.log` : connexions, blocages, CSRF, robots |
| Chiffrement des données sensibles | ✅ | Nom, téléphone, e-mail et commentaire chiffrés en AES-256-GCM |
| Clés d'API exposées / secrets Git | ✅ | Aucun secret dans le code (recherche faite) ; `storage/` et le fichier de contexte ignorés par Git |
| Dépendances | ✅ | Pas de gestionnaire de paquets ; 2 scripts CDN en version figée avec Subresource Integrity |
| Requêtes paramétrées | ➖ | Pas de base de données. Utiliser PDO et des requêtes préparées lors du passage à MySQL |
| Droits de la base, accès par défaut, RLS, clé publique de base | ➖ | Pas de base de données |
| Accès aux enregistrements | ➖ | Un seul rôle (admin) ; à prévoir si plusieurs agences ont des comptes |
| Réinitialisation de mot de passe (liens, sessions, débit) | ➖ | Pas de réinitialisation en ligne : le mot de passe se change par variable d'environnement |
| Upload de fichiers | ➖ | Aucun upload |
| Paiements, webhooks Stripe, prix côté serveur, cartes bancaires | ➖ | Aucun paiement en ligne, aucune donnée bancaire collectée |
| Injection de prompt, plafond d'usage IA | ➖ | Aucune fonctionnalité d'IA |

## 3. Performance

| Contrôle | État | Détail |
| --- | --- | --- |
| Images optimisées | ✅ | Sculpture en WebP (230 Ko, 190 Ko en version mobile), image Open Graph en JPEG (100 Ko), dimensions déclarées |
| Test de charge | ✅ | 300 requêtes, 10 en parallèle : 0 échec, ~98 req/s sur le serveur de développement PHP (mono-processus) |
| Compression et cache | ✅ | gzip et cache long des fichiers statiques dans `.htaccess` (versionnés par `?v=`) |
| Animation | ✅ | Le WebGL se met en pause hors écran et onglet masqué ; mouvement réduit respecté |
| Requêtes N+1, re-rendus inutiles | ➖ | Pas de base de données ni de framework réactif |

## 4. SEO, contenu et éléments du site

| Élément | État | Détail |
| --- | --- | --- |
| Titre et description par page | ✅ | Définis dans chaque contrôleur |
| Balise canonique | ✅ | Sur toutes les pages publiques |
| Image Open Graph | ✅ | `assets/img/og-image.jpg` (1200 × 630) |
| Données structurées | ✅ | JSON-LD Organization avec horaires et téléphone |
| `sitemap.xml`, `robots.txt` | ✅ | Générés ; `/admin` et `/api/` exclus |
| `llms.txt` | ✅ | `public/llms.txt` |
| Favicon | ✅ | SVG, PNG 32 px, icône Apple 180 px |
| Page 404 personnalisée | ✅ | Avec liens vers l'accueil, l'estimation et les agences |
| CTA au-dessus de la ligne de flottaison | ✅ | « Estimer gratuitement » dans le hero et l'en-tête |
| CTA fixe sur mobile | ✅ | Barre Appeler / Estimer après le premier écran, masquée sur le formulaire et le pied de page |
| Numéro cliquable | ✅ | Liens `tel:` partout |
| Horaires | ✅ | Bloc contact et pied de page |
| Garanties | ✅ | Bandeau sous le hero et page À propos |
| Moyens de paiement | ✅ | Chèque de banque ou virement sous 24 h (garanties, CGU) |
| États d'erreur du formulaire | ✅ | Messages par champ, côté navigateur et serveur |
| États de chargement | ✅ | Bouton « Envoi en cours… », graphiques « Chargement » / erreur |
| Page de remerciement | ✅ | Confirmation dans le formulaire avec la référence de la demande |
| Bannière cookies | ✅ | Accepter / Refuser, modifiable depuis le pied de page ; la mesure d'audience ne se charge qu'après accord |
| Page À propos | ✅ | Histoire, activités, engagements |
| Politique de confidentialité, CGU, mentions légales | 🔧 | Pages en place, textes à compléter et à valider |
| Adresse réelle, e-mail visible | 🔧 | E-mail provisoire affiché ; adresse à renseigner |
| Analytics | 🔧 | Prêt (GTM après consentement), identifiant à fournir |
| Google Search Console | 🔧 | À faire après la mise en ligne |
| Liens réseaux sociaux | 🔧 | Volontairement absents tant que les comptes ne sont pas confirmés |
| Une page par service | 🔧 | À faire (rachat d'or, montres, change...), utile pour le SEO local |
| 5 articles de blog | 🔧 | Le blog existant (actus) peut être relié |
| Galerie avant / après | ➖ | Peu pertinent pour du rachat ; à remplacer par des avis clients vérifiés |
| Infobulles enrichies | ✅ | Couvert par les données structurées et Open Graph |
| Texte alternatif des images | ✅ | Seule image : décorative (`alt=""`, masquée aux lecteurs d'écran) |

## 5. Tests et UX

| Contrôle | État | Détail |
| --- | --- | --- |
| États vides | ✅ | Demandes d'estimation (admin), tournées (site) |
| Écran mobile | ✅ | Testé à 390 px : pas de défilement horizontal, menu, CTA fixe |
| Chaque bouton fonctionne | ✅ | Boutons inactifs retirés (« Voir tout », recherche) ; menus « Bientôt » signalés |
| Parcours complet testé | ✅ | Navigateur automatisé : bannière cookies, formulaire en 3 étapes, connexion, demande visible dans l'admin, aucune erreur console ni violation CSP |
