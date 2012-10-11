jQuery(function($){
	
	//== Masks
	$('#person_address_zip').mask('99999-999');
	$('#person_cpf').mask('999.999.999-99');
	$('.phone').mask('(99) 9999-9999');


	//== Ticket helpers
	// Always clears ticket code on page load.
	$('.ticket').val('');

	// Moves to the next ticket field once one is filled in;
	// moves to the previous one (if any) if backspace is pressed
	// on an empty field.
	$('.ticket').live('keyup', function(event){
		var $this = $(this);

		var $current = $this;
		while($current.prev('.ticket').length){ $previous = $current.prev('.ticket');
			if($previous.val().length < 3){
				$previous.val($previous.val()+ $current.val());
				console.log( $previous.val()+ $current.val() );
				$current.val('');
				$previous.focus();
			}
			$current = $previous;
		}

		if($this.val().length == 3){
			$this.next().focus();
		} else {
			var key = (event.keyCode ? event.keyCode : event.which );
			if($this.val().length == 0 && key == 8 ){
				if($this.prev())
					$this.prev().focus();
			}
		}
	});
	

	//== Validations
	jQuery.validator.setDefaults({

		// Pops out all errors out of errorList, except the first one.
		showErrors: function(errorMap, errorList){
			if(errorList.length){
				var n = [];
				n.push(errorList.shift());
				this.errorList = n;
			}
			this.defaultShowErrors();

		},

		// Adds the 'error' class to the failed field, and shows its error message
		// on the #error div.
    	errorPlacement: function(error, element) {
    		$element = $(element);
    		$('#registration_form input div').removeClass('error');
    		var failedId = $element.attr('id');
    		var labelText = $("label[for='"+failedId+"']").html();
    		$('#errors').html(error);
    		if($element.hasClass('ticket')){
    			$('.ticket').addClass('error');
    		} else {
    			if($element.attr('type') == 'text'){
    				$element.addClass('error');		
    			} else {
    				$element.parent().addClass('error');
    			}
    			
    		}
    	}
	});

	$('#registration_form').validate();

	
	//== Address controls
	// Locks address fields, unless ZIP code is already filled in.
	if($('#person_address_zip').val().length < 9){
		$('.zip-dependant input').prop('disabled', true);
	}

	// Fills and unlocks address fields with info from its ZIP code.
	$('#person_address_zip').live('keyup', function(event){
			if($(this).val().length >= 9){
				$(this).cep({
					success: function(data){ 
						$('#person_address_street')[0].value = data.logradouro ;
						$('#person_address_district')[0].value = data.bairro ;
						$('#person_address_state')[0].value = data.estado ;
						$('#person_address_city')[0].value = data.cidade ;
						$('.zip-dependant input').prop('disabled', false);
						$('#person_address_number').focus();
					},
					error: function(data){
						$('#errors').html('Não conseguimos encontrar um endereço para este CEP. Se tem certeza que usou o CEP correto, favor preencher o endereço manualmente.');
					} 
				}) ;
			}
		});
});

var RecaptchaOptions = {
	theme : 'clean'
};