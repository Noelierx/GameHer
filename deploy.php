<?php
namespace Deployer;

require 'recipe/symfony4.php';

set('application', 'gameher');
set('repository', 'git@github.com:Noelierx/GameHer.git');
set('allow_anonymous_stats', false);
set('git_tty', false);
set('default_timeout', 600);

add('shared_files', []);
add('shared_dirs', ['public/uploads']);
add('writable_dirs', ['public/uploads']);

task('build', function () {
    run('cd {{release_path}} && build');
});

task('deploy:npm:install', 'npm install')->desc('Installing node modules');
task('deploy:npm:build', 'npm run build')->desc('Running webpack');

after('deploy:failed', 'deploy:unlock');

before('deploy:symlink', 'database:migrate');
before('deploy:cache:clear', 'deploy:npm:build');
before('deploy:npm:build', 'deploy:npm:install');

//Setup host
host('161.35.75.9')
	->user('gameher')
	->multiplexing(false)
	->forwardAgent(true)
	->set('deploy_path', '~/{{application}}');
