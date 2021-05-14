![GameHer Social Banner](https://pbs.twimg.com/profile_banners/895352686295617536/1576449060/1500x500)
[![Pull Requests Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat)](http://makeapullrequest.com)
[![first-timers-only Friendly](https://img.shields.io/badge/first--timers--only-friendly-blue.svg)](http://www.firsttimersonly.com/)
[![Open Source Helpers](https://www.codetriage.com/noelierx/gameher/badges/users.svg)](https://www.codetriage.com/noelierx/gameher)
[![CI](https://github.com/Noelierx/GameHer/actions/workflows/ci.yml/badge.svg)](https://github.com/Noelierx/GameHer/actions/workflows/ci.yml)
[English version](README.md)

# GameHer
[Gameher.fr](https://gameher.fr/) est une association française qui aspire à développer la mixité dans les domaines du jeu vidéo, de l'esport et du steaming. 
Elle est gérée par une grande équipe de bénévoles dans le but de développer un environnement sain pour tous les joueurs.
Nous voulons leur donner les outils dont ils ont besoin pour s'épanouir et évoluer ces domaines.

Si vous souhaitez nous soutenir, vous pouvez faire [un don] ou vous pouvez créer un compte pour [Digital Ocean] avec notre lien d'affiliation : [Digital Ocean]

[Digital Ocean]: https://m.do.co/c/20ded2e61f92
[un don]: https://gameher.fr/donations

### Installation

Cloner le projet et installer ses dépendances :
```
composer install
npm install
```
### Configuration
```
cp .env .env.local
```
Modifier `.env.local`
- **APP_ENV**: Symfony env, habituellement `dev` ou `prod`
- **APP_SECRET**: Clé secrète
- **DATABASE_URL**: url pour connexion à la base de donnée
- **OAUTH_DISCORD_ID**: Requis pour OAuth, obtenir sur Discord (voir [configurer Discord](#configurer-discord))
- **OAUTH_DISCORD_SECRET**: Requis pour OAuth, obtenir sur Discord (voir [configurer Discord](#configurer-discord))

Créer votre base de donnée et exécuter les migrations :
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

Voilà, vous êtes prêt!

### Développer
Deux options s'offre à vous :
#### A - [Symfony CLI](https://symfony.com/download)
`symfony server:start`
#### B - Apache / Nginx ?
Configurer puis pointer sur le dossier `public`

#### Serveur Webpack (Optionnel)
`npm run watch`

---
Puis allez sur `http://localhost:3000` (Symfony CLI) ou sur votre webserveur pour commener à travailler

### Configurer Discord
L'application utilise le OAuth de Discord pour gérer les utilisateur. Pour se connecter et accéder au panneau d'administration, voici comment : 

Visitez [Discord's Developer Portal](https://discordapp.com/developers/applications) et créez une **New Application** et saisir le nom  
Dans l'onglet *General Information*, copiez **client ID** et **client Secret** pour ajouter à votre fichier de configuration `.env.local`  
Dans l'onglet *OAuth2*, cliquez sur **Add Redirect** et entrez l'url de redirection de l'app. Voici le format :  
`http://YOUR_APP_URL/connect/discord/check`  

Dans la section scopes, sélectionnez `identify`, `email` et `connections`

Finalement, **Save Changes** ! Vous pouvez maintenant vous connectez à l'application

### Extensions PHP 

`sudo apt-get install php7.3 php7.3-cli php7.3-common php7.3-fpm php7.3-mysql php7.3-intl php7.3-curl  php7.3-zip php7.3-xml`

### Comment contribuer
Utiliser l'**Anglais** pour vos messages de `commit` et vos `merge request`.

#### [Première fois avec GitHub](https://git-scm.com/book/fr/v2/GitHub-Contribution-%C3%A0-un-projet)
