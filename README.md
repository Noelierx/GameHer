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

### PHP Extensions

`sudo apt-get install php7.3 php7.3-cli php7.3-common php7.3-fpm php7.3-mysql php7.3-intl php7.3-curl  php7.3-zip php7.3-xml`

# How to contribute
Fork this repository by clicking on the fork button on the top of this page. This will create a copy of this repository in your account. Then you will need to clone the repository to work on it !
`$ git clone git@github.com:USERNAME/GameHer.git` where `USERNAME` is your GitHub username.

Then you need to go in your repository `$ cd GameHer` you will also need to set up a new remote that points to the original project so that you can grab any changes and bring them into your local copy.
`$ git remote add upstream git@github.com:Noelierx/GameHer.git`
And you good to work ! Now you just have to create new branches like that : 
`$ git checkout -b <add-your-new-branch-name>` Do your stuff and then commit with this command line : `git commit -m "Stuff you have done"`
Then, you will have to do a pull request by typing `$ git push origin <add-your-branch-name>`
And go back to github to click on the button 'Compare and Pull Request'. 
