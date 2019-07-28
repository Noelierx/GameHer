require('materialize-css');
require('materialize-css/dist/css/materialize.css');
require('materialize-css/dist/js/materialize.min.js');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.min.js');
require('../css/app.css');
const $ = require('jquery');


$('.leagueTeams__button').click(function ($event) {
	$event.preventDefault();
	$('.esportToggled').slideToggle();
	$('.leagueTeams').toggleClass('opened')
});

$('.dropdown-trigger').dropdown();

$('.dismiss').click(function ($event) {
	$event.preventDefault();
	$(this).parent().fadeOut();
});
