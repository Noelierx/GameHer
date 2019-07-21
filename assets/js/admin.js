require('bootstrap/dist/css/bootstrap.min.css');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
const $ = require('jquery');
require('bootstrap');
require('../css/admin.css');

$(document).ready(function() {
	$('[data-toggle="popover"]').popover();
});

