require('datatables/media/js/jquery.dataTables.min');
require('datatables/media/css/jquery.dataTables.min.css');
require('../css/admin.css');
const $ = require('jquery');

$('select').formSelect();

$('.datepicker').datepicker({
	format: 'yyyy-mm-dd',
	firstDay: 1
});

$('.timepicker').timepicker({
	twelveHour: false
});

$('.dismiss').click(function ($event) {
	$event.preventDefault();
	$(this).parent().fadeOut();
});

$('#members').dataTable();
