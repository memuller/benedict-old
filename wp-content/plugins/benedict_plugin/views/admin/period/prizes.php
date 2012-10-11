<div id="prizes">
	<h2><?php echo "Premiação" ?></h2>
	<?php $prizes = get_posts(array('post_type' => 'prize')); ?>
	<table class='form-table'>
		<tbody>
			<?php for ($i=1; $i <= $period->num_prizes; $i++) { ?>
				<tr class="prize">
					<th>
						<label for="period_prize_<?php echo $i ?>"> <?php echo $i.'º prêmio' ?> </label>
					</th>
					<td>
						<select name="period[prizes][]" id="period_prize_<?php echo $i ?>">
							<?php foreach($prizes as $prize){ 
								$selected = $period->prizes[$i-1] == $prize->ID ? 'selected' : '' ?>
								<option <?php echo $selected ?> value="<?php echo $prize->ID ?>"><?php echo $prize->post_title ?></option>
							<?php } ?>
						</select>
						<?php if($i == 1 ) description('selecione o prêmio mais relevante como sendo o primeiro.') ?>
					</td>
				</tr>
			<?php } ?>		
		</tbody>
	</table>
</div>