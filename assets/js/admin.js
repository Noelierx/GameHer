
require('../css/admin.css');

const $ = require('jquery');
$(document).ready(function(){
	$('select').formSelect();
	$('.datepicker').datepicker();
});
