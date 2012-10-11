<?php
	namespace CasaNova ;  
	use CustomPost ;

	class Product extends CustomPost {
		static $name = "product" ;
		static $creation_fields = array( 
			'label' => 'product','description' => 'Um produto participante da promoção.',
			'public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post', 'map_meta_cap' => true, 
			'hierarchical' => false,'rewrite' => array('slug' => 'produtos'),'query_var' => true,
			'supports' => array('custom-fields', 'title', 'thumbnail', 'editor'), 
			'has_archive' => true, 'taxonomies' => array(),
			'labels' => array (
				'name' => 'Produtos',
				'singular_name' => 'Produto',
				'menu_name' => 'Produtos',
				'add_new' => 'Adicionar novo',
				'add_new_item' => 'Cadastrar novo produto',
				'edit' => 'Alterar',
				'edit_item' => 'Alterar produto',
				'new_item' => 'Registrar produto',
				'view' => 'Consultar',
				'view_item' => 'Consultar produto')
		) ;

		static $fields = array(
			'url' => array('type' => 'text', 'label' => 'Url', 'description' => 'URL para aquisição do produto na Loja Virtual.', 'size' => 40)
		) ;
		static $absent_actions = array('quick-edit', 'view');
		static $editable_by = array('main_metabox');


		
	}

 ?>