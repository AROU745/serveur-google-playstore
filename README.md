# Serveur Google Playstore

Application web **Google Play Server Service** (Laravel 10) — service indépendant, non affilié à Google LLC.

**Compte GitHub :** [AROU745](https://github.com/AROU745)  
**Dépôt :** https://github.com/AROU745/serveur-google-playstore

> Important : GitHub héberge le **code source**. Ce projet Laravel (PHP + MySQL) ne peut pas tourner directement sur GitHub Pages. Pour ouvrir le site en ligne, déployez-le sur un hébergeur PHP (XAMPP en local, ou un hébergeur web avec PHP 8.2+ et MySQL).

## Stack

- Laravel 10 / PHP 8.2+
- MySQL
- Blade + Bootstrap 5 + Font Awesome

## Installation locale (XAMPP)

```bash
composer install
copy .env.example .env
php artisan key:generate
# Configurer DB dans .env (DB_DATABASE=gpss, etc.)
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Admin par défaut (à changer) : `admin@gpss.local` / `Admin@GPSS2024`

## Fonctionnalités

- Landing + souscription (1 082 USD, durée indéterminée)
- Paiement Wise + dossier Visa (documents)
- Console applications (RapidTogo, Taoman Groupe, Oket)
- Administration des commandes

## Licence / disclaimer

Service indépendant — Non affilié à Google LLC.
