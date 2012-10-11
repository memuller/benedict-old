<div class='wrap'>
	<div class="icon32 icon-users"></div>
	<h2><?php echo "Cadastrar cupom físico" ?></h2>
	<?php if (isset($success) && $success): ?>
		<div id="message" class="updated below-h2">
			<p>
				<?php echo "Cupom cadastrado com sucesso." ?>
			</p>
		</div>
	<?php endif ?>
	<?php if (isset($error)): ?>
		<div id="message" class="bellow-h2 error">
			<p>
				<?php echo 'invalid' == $error ? 'Cupom inexistente ou inválido.' : 'Cupom já cadastrado anteriormente.' ?>
				<?php echo 'Favor destruí-lo imediatamente.' ?>
			</p>
		</div>
	<?php endif ?>

	<form action="" method="POST" id="registration_form">
		<table class="form-table">
			<tbody>
				<tr>
					<th> <?php echo "Código do cupom" ?></th>
					<td>
						<input type="text" id="registration_ticket" size="12" name="registration[ticket]" autocomplete='off' maxlength="9"> <br/>
						<?php description("Favor inserir o código do cupom recebido fisicamente. <br/>Você pode utilizar um leitor de código de barras.") ?>
					</td>
				</tr>

			</tbody>
		</table>
		<input type="hidden" name="action" value="register_physical">
	</form>
</div>
