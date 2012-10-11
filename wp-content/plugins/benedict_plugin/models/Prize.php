<?php
	namespace CasaNova ;  
	use CustomPost ;

	class Prize extends CustomPost {
		static $name = "prize" ;
		static $creation_fields = array( 
			'label' => 'prize','description' => 'Um prêmio, sorteado ao longo da promoção.',
			'public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post', 'map_meta_cap' => true, 
			'hierarchical' => false,'rewrite' => array('slug' => 'prêmios'),'query_var' => true,
			'supports' => array('custom-fields', 'title', 'editor', 'thumbnail'), 
			'has_archive' => true, 'taxonomies' => array(),
			'labels' => array (
				'name' => 'Prêmios',
				'singular_name' => 'Prêmio',
				'menu_name' => 'Premiação',
				'add_new' => 'Adicionar novo',
				'add_new_item' => 'Cadastrar novo prêmio',
				'edit' => 'Alterar',
				'edit_item' => 'Alterar prêmio',
				'new_item' => 'Criar novo prêmio',
				'view' => 'Consultar',
				'view_item' => 'Consultar prêmio',)
		) ;

		static $fields = array(
		) ;
		static $absent_actions = array('quick-edit', 'view');


		
	}

 ?>