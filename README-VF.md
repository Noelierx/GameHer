![GameHer Social Banner](https://pbs.twimg.com/profile_banners/895352686295617536/1576449060/1500x500)
[![Pull Requests Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat)](http://makeapullrequest.com)
[![first-timers-only Friendly](https://img.shields.io/badge/first--timers--only-friendly-blue.svg)](http://www.firsttimersonly.com/)
[![Open Source Helpers](https://www.codetriage.com/noelierx/gameher/badges/users.svg)](https://www.codetriage.com/noelierx/gameher)
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
## TODO TRANSLATE START
Copy the `.env.dist` file in a new `.env` file, and configure it according to your environment:

- **APP_ENV**: Symfony env, usually `dev` or `prod`
- **APP_SECRET**: Your secret
- **DATABASE_URL**: url to connect to your database
- **OAUTH_DISCORD_ID**: Required for OAuth, get it from Discord (see [configuring Discord](#configuring-discord))
- **OAUTH_DISCORD_SECRET**:  Required for OAuth, get it from Discord (see [configuring Discord](#configuring-discord))

Create your database and run migrations
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

That's it, you are ready
## TODO TRANSLATE END

### Develop
Deux options s'offre à vous :
#### A - [Symfony CLI](https://symfony.com/download)
`symfony server:start`
#### B - Apache / Nginx ?
Configurer puis pointer sur le dossier `public`

#### Serveur Webpack (Optionnel)
`npm run watch`

---
Puis allez sur `http://localhost:3000` (Symfony CLI) ou sur votre webserveur pour commener à travailler

## TODO TRANSLATE START
### Configuring Discord

The app uses Discord's OAuth server to handle user. In order to login and access the admin panel, you need to configure a Discord app.

Head over to [Discord's Developer Portal](https://discordapp.com/developers/applications) and create a **New Application** and fill its name  
On the *General Information* tab, you can retrieve the client ID and client Secret that you need to add to your `.env` file  
On the *OAuth2* tab, click on **Add Redirect** and enter the app's redirect url. The format will be:  
`http://YOUR_APP_URL/connect/discord/check
`  
In the scopes section, select `identify`, `email` and `connections`

Finally, **Save Changes** ! You can now log into the app
## TODO TRANSLATE END

### Extensions PHP 

`sudo apt-get install php7.3 php7.3-cli php7.3-common php7.3-fpm php7.3-mysql php7.3-intl php7.3-curl  php7.3-zip php7.3-xml`

### Comment contribuer
Utiliser l'**Anglais** pour vos messages de `commit` et vos `merge request`.

#### [Première fois avec GitHub](https://git-scm.com/book/fr/v2/GitHub-Contribution-%C3%A0-un-projet)
