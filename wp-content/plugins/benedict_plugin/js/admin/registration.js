jQuery(document).ready( function($) {
	$('#registration_ticket').focus();
	$('#registration_form').on('keyup', '#registration_ticket', function(event){
		if($(this).val().length == 9){
			$('#registration_form').submit();
		}
	});
});