# GameHer
Le futur nouveau de Game'Her

### Setup

Clone the project and install its dependencies:
```
composer install
npm install
```

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

### Develop

If you use the [Symfony CLI](https://symfony.com/download) you can launch a development server with `symfony server:start`, otherwise you need to configure your Apache installation to serve the files from the `public` folder.  
You can then launch the webpack server with a watcher by running `npm run watch`

Then head over to http://localhost:3000 (with Symfony CLI) or to your webserver to start working

### Configuring Discord

The app uses Discord's OAuth server to handle user. In order to login and access the admin panel, you need to configure a Discord app.

Head over to [Discord's Developer Portal](https://discordapp.com/developers/applications) and create a **New Application** and fill its name  
On the *General Information* tab, you can retrieve the client ID and client Secret that you need to add to your `.env` file  
On the *OAuth2* tab, click on **Add Redirect** and enter the app's redirect url. The format will be:  
`http://YOUR_APP_URL/connect/discord/check
`  
In the scopes section, select `identify`, `email` and `connections`

Finally, **Save Changes** ! You can now log into the app
