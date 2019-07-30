require('../css/admin.css');
const $ = require('jquery');

$('select').formSelect();

$('.datepicker').datepicker({
	format: 'yyyy-mm-dd',
	firstDay: 1
});

$('.dismiss').click(function ($event) {
	$event.preventDefault();
	$(this).parent().fadeOut();
});
