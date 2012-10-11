<h2><?php _e('Questão') ?></h2>
<?php wp_editor($question->text, 'question_text', array('textarea_name' => 'question[text]', 'textarea_rows' => 5,  'media_buttons' => false));  ?>
<h2><?php _e('Resposta') ?></h2>
<?php wp_editor($question->answer, 'question_answer', array('textarea_name' => 'question[answer]', 'textarea_rows' => 10,  'media_buttons' => false)); ?>