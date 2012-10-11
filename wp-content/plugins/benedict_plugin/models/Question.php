<?php
	namespace CasaNova ;  
	use CustomPost ;

	class Question extends CustomPost {
		static $name = "question" ;
		static $creation_fields = array( 
			'label' => 'question','description' => 'Um conjunto de dúvida frequente e sua resposta.',
			'public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post', 'map_meta_cap' => true, 
			'hierarchical' => false,'rewrite' => array('slug' => 'faq'),'query_var' => true,
			'supports' => array('custom-fields'), 
			'has_archive' => true, 'taxonomies' => array(),
			'labels' => array (
				'name' => 'FAQ',
				'singular_name' => 'Questão',
				'menu_name' => 'FAQ',
				'add_new' => 'Nova questão',
				'add_new_item' => 'Adicionar nova questão',
				'edit' => 'Editar',
				'edit_item' => 'Editar questão',
				'new_item' => 'Nova questão',
				'view' => 'Ver',
				'view_item' => 'Ver questão',
				'search_items' => 'Buscar questões',
				'not_found' => 'Nenhuma questão cadastrada',
				'not_found_in_trash' => 'Nenhuma questão foi encontrada na lixeira.'
			)
		) ;

		static $fields = array(
			'text' => array('type' => 'rich_text'),
			'answer' => array('type' => 'rich_text')
		) ;
		static $absent_actions = array('quick-edit', 'view');
		
		
		static function build(){
			parent::build();
			$class = get_called_class();
			add_action('edit_form_advanced', function() use($class){
				$screen = get_current_screen() ; 
				if($screen->post_type == $class::$name){
					$question = new Question();
					\CasaNova\Presenters\Base::render('admin/question/edit_form_advanced', array('question' => $question));
				}
			}) ;

			add_filter('title_save_pre', function($title){
				if($_POST['post_type'] == 'question'){
					$title = $_POST['question']['text'];
				}
				return $title ;
			}) ;
		}


		
	}

 ?>