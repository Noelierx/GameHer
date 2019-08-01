require('normalize.css/normalize.css');
require('materialize-css');
require('materialize-css/dist/css/materialize.css');
require('materialize-css/dist/js/materialize.min.js');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.min.js');
require('../css/app.css');
const $ = require('jquery');

$('select').formSelect();
$('.dropdown-trigger').dropdown();

//Blog
$('#news__categories').change(function ($event) {
	$event.preventDefault();
	window.location.href = window.location.origin + '/blog?tag=' + $(this).val().toLowerCase();
});

//Esport
$('.leagueTeams__button').click(function ($event) {
	$event.preventDefault();
	var $buttonOpened = $('.leagueTeams__button.opened');
	var $toggle = $('.esportToggled');

	if ($(this).hasClass('opened')) {
		$buttonOpened.removeClass('opened');
		$toggle.slideUp();
		return;
	}

	$buttonOpened.removeClass('opened');
	$toggle.hide();

	$(this).addClass('opened');
	$('.esportToggled.' + $(this).attr('data-team')).slideDown();
});

//Tournaments
$('.gameherLeague__button').click(function ($event) {
	$event.preventDefault();
	$('.gameherLeague__infography').slideToggle();
	$('.gameherLeague').toggleClass('opened')
});

//About
$('.memberToggle').click(function ($event) {
	$event.preventDefault();
	if ($(this).hasClass('active')) {
		return;
	}

	$('.memberToggle').removeClass('active');
	$(this).addClass('active');
	$('.membersList').hide().removeClass('active');
	$('.membersList.' + $(this).attr('data-toggle')).fadeIn().addClass('active');
});
