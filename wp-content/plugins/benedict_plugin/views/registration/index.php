<section id="cadastro">
	<div id="errors" <?php if(isset($errors)) echo "class='recaptcha'" ?> >
		<?php if (isset($errors)): ?>
			<p><?php echo "Os caracteres digitados não correspondem aos exibidos." ?> <br> <?php echo "Preencha seu cupom e caracteres e tente novamente." ?></p>
		<?php endif ?>
	</div>
	<form id="registration_form" method="post" action="">
			
		<fieldset id="code" class="">
			<legend></legend>
			<label for="registration_ticket_1">Código do CUPOM*</label>
			<input id="registration_ticket_1" class="required ticket" name="registration[ticket][1]" type="text" maxlength='3' /> 
			<input id="registration_ticket_2" class="required ticket" name="registration[ticket][2]" type="text" maxlength='3' /> 
			<input id="registration_ticket_3" class="required ticket" name="registration[ticket][3]" type="text" maxlength='3' /> 
		</fieldset>
			
		<fieldset id="person-info" class="">
			<legend></legend>
			<div class="full">
				<label for="person_name">Nome Completo*</label>
				<input id="person_name" class="required" name="person[name]" type="text" value="<?php if(isset($person)) echo $person['name'] ?>"/> 
			</div>
			<div class="">
				<label for="person_rg">RG*</label>
				<input id="person_rg" name="person[rg]" class="required" type="text" value="<?php if(isset($person)) echo $person['rg'] ?>"/>
			</div>
			<div class="right">
				<label for="person_cpf">CPF*</label>
				<input id="person_cpf" name="person[cpf]" class="required cpf" type="text" value="<?php if(isset($person)) echo $person['cpf'] ?>"/>
			</div>
		</fieldset>

		<fieldset id="person-address" class="">
			<legend></legend>
			<div class="">
				<label for="person_address_zip">CEP*</label>
				<input id="person_address_zip" type="text" class='required' name="person[address_zip]" 
					value="<?php if(isset($person)) echo $person['address_zip'] ?>"/>
			</div>
			<div class="zip-dependant">
				<div class="">
					<label for="person_address_street">Endereço*</label>
					<input id="person_address_street" class="required" name="person[address_street]" type="text" 
						value="<?php if(isset($person)) echo $person['address_street'] ?>"/>
				</div>
				<div class="right">
					<label for="person_address_number">Número*</label>
					<input id="person_address_number" class="required digits" name="person[address_number]" type="text" 
						value="<?php if(isset($person)) echo $person['address_number'] ?>"/>
				</div>
				<div class="">
					<label for="person_address_complement">Complemento</label>
					<input id="person_address_complement" name="person[address_complement]" type="text" 
						value="<?php if(isset($person)) echo $person['address_complement'] ?>"/>
				</div>
				<div class="right">
					<label for="person_address_district">Bairro*</label>
					<input id="person_address_district" name="person[address_district]" type="text" 
						value="<?php if(isset($person)) echo $person['address_district'] ?>"/>
				</div>
				<div class="">
					<label for="person_address_city">Cidade*</label>
					<input id="person_address_city" name="person[address_city]" class='required' type="text" 
						value="<?php if(isset($person)) echo $person['address_city'] ?>"/>
				</div>
				<div class="">
					<label for="person_address_state">Estado*</label>
					<input id="person_address_state" name="person[address_state]" class='required' type="text" size="2" 
						value="<?php if(isset($person)) echo $person['address_state'] ?>"/>
				</div>
				<div class="right">
					<label for="person_address_country">País</label>
					<input id="person_address_country" name="person[address_country]" class='required' type="text" />
				</div>
			</div>	
		</fieldset>
		
		<fieldset id="person-contact" class="">
			<legend></legend>
			<div class="">
				<label for="person_phone_main">Telefone*</label>
				<input id="person_phone_main" name="person[phone_main]" class='required phone' type="text" 
					value="<?php if(isset($person)) echo $person['phone_main'] ?>"/>
			</div>
			<div class="right">
				 <label for="person_phone_mobile">Celular*</label>
				 <input id="person_phone_mobile" name="person[phone_mobile]" class='phone either' type="text" 
				 	value="<?php if(isset($person)) echo $person['phone_mobile'] ?>"/>
			</div>
			<div class="full">
				<label for="person_email">E-mail*</label>
				<input id="person_email" name="person[email]" class='either email' type="text" 
					value="<?php if(isset($person)) echo $person['email'] ?>"/>
			</div>
		</fieldset>
		<fieldset id="agreements" class="">
			<legend></legend>
			<div id="ask">
				<p>Responda a pergunta:</p>
				<label id="completar">Ser Canção Nova é?</label> 
				<input type="radio" value="1" name="registration[answer]" id="bomdemais" class='required' />
				<label for="bomdemais">Bom Demais</label>
				<input type="radio" value="0" name="registration[answer]" id="outros" />
				<label for="outros">Outros</label>
			</div>
			<div id="rules">
				<input type="checkbox" name="registration[rules]" id="registration_rules" value="1" class='required'>
				<label for="registration_rules">Li e concordo com o regulamento.</label>
			</div>
			<div id="receive">
				<div>
					<input type="checkbox" name="person[wants_newsletter][]" id="wants_newsletter_mail" value="email" />
					<label for="r_email">Quero receber novidades Canção Nova em meu e-mail e pelos correios.</label>
				</div>
				<div>
					<input type="checkbox" name="person[wants_newsletter][]" id="wants_newsletter_sms" value="sms" />
					<label for="r_sms">Quero receber novidades Canção Nova por SMS.</label>
				</div>
			</div>
			<div id="captcha-box" class="">
				<?php if (isset($errors)): ?>
					<p class="recaptcha"><?php echo "Os caracteres digitados não correspondem aos exibidos." ?> <br> <?php echo "Tente novamente." ?></p>
				<?php endif ?>
				<p>Digite o que você lê abaixo:</p>
				<?php echo recaptcha_get_html(RECAPTCHA_PUBLIC_KEY) ?>
			</div>
		</fieldset>
		</div>
			<input class="submit" type="submit" value="Enviar Cupom" id="send" />
		</div>
		<input type="hidden" name="action" value="register_online">
	</form> 
</section>