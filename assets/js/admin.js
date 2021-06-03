require('datatables/media/js/jquery.dataTables.min');
require('datatables/media/css/jquery.dataTables.min.css');
require('../css/admin.scss');
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

$('#members').dataTable();
