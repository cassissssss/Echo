# Echo — Histoire interactive avec Laravel & Vue

> **Echo** est une application web interactive racontant une histoire narrative où les choix du joueur influencent la progression et la fin.  
> Le backend est construit avec **Laravel**, l’interface utilisateur avec **Vue.js 3**, et les données sont stockées en base de données via Eloquent.

---

## 📁 Structure du projet

Le projet est découpé en deux parties distinctes :

-   `echo-backend` : API RESTful Laravel (chapitres, histoires, choix, utilisateurs)
-   `echo-frontend` : Application Vue.js 3 qui consomme l’API

---

## Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/cassissssss/echo.git
cd echo
2. Installer le tout
cd WebMobUI52-fullstack
composer install

npm install

npm run build

Créer un fichier .env si non existant :
    cp .env.example .env

php artisan key:generate

php artisan migrate --seed

composer artisan serve
    Assurez-vous que PHP 8.1+, Composer et SQLite/MySQL sont installés.

L'application est finalement accessible via http://127.0.0.1:8000

Authentification
Système de connexion via /login ou l'icone profile

Middleware auth protègent /dashboard et les routes API sensibles

Un utilisateur admin est créé automatiquement avec :

Email : admin@echo.ch

Mot de passe : 1234

Fonctionnalités principales :

- Choix narratifs avec impact sur l’histoire
- Attribution de traits de personnalité selon les décisions du joueur
- Fins personnalisées (archétypes) en fonction des choix
- API sécurisée avec middleware

⚡ Frontend Vue dynamique & responsive

API Routes (extrait)
Méthode	URI	Description
GET	/api/v1/stories	Récupère toutes les histoires
GET	/api/v1/stories/{id}	Une histoire par ID
GET	/api/v1/story/{id}/first-chapter	Premier chapitre de l’histoire

L'ensemble des routes se trouve dans routes/api.php et dans routes/web.php

Développement & outils
- Laravel 12.x
- Vue.js 3 + Vite
- SQLite (en local) ou MySQL

Autrice :
Christel

Licence
Ce projet est à usage pédagogique. Toute réutilisation doit citer la source.
```
