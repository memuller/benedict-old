jQuery(document).ready( function($) {
	$('.date').datepick();

	$('#period_num_prizes').one('keyup', function(event){
		$(this).after("<br/><span class='description' style='color: red;'> Após alterar o número de prêmios, salve o período para configurá-los. </span>");
		$('#prizes').hide(300);
	});

});