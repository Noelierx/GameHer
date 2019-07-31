require('materialize-css');
require('materialize-css/dist/css/materialize.css');
require('materialize-css/dist/js/materialize.min.js');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.min.js');
require('../css/app.css');
const $ = require('jquery');

$('select').formSelect();
$('.dropdown-trigger').dropdown();

$('.leagueTeams__button').click(function ($event) {
	$event.preventDefault();

	if ($(this).hasClass('opened')) {
		$('.leagueTeams__button.opened').removeClass('opened');
		$('.esportToggled').slideUp();
	} else {
		$('.leagueTeams__button.opened').removeClass('opened');
		$('.esportToggled').slideUp();

		$(this).addClass('opened');
		$('.esportToggled.' + $(this).attr('data-team')).slideDown();
	}
});

$('#news__categories').change(function ($event) {
	$event.preventDefault();
	window.location.href = window.location.origin + window.location.pathname + '?tag=' + $(this).val().toLowerCase();
});

$('.memberToggle').click(function ($event) {
	$event.preventDefault();
	if ($(this).hasClass('active')) {
		return;
	}

	$('.memberToggle').removeClass('active');
	$(this).addClass('active');
	$('.membersList').slideUp().removeClass('active');
	$('.membersList.' + $(this).attr('data-toggle')).slideDown().addClass('active');
});
