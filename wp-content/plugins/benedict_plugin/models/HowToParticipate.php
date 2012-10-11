<?php
	namespace CasaNova ;
	use BasePost;  

	class HowToParticipate  extends BasePost {

		static $name = 'HowToParticipate';
		static $post_type = 'page';
		static $title = 'Como participar';
		static $uses = array('template' => 'howto-participate');
		static $does_not_have = array('title', 'editor');

		static $fields = array(
			'product' => array('type' => 'text_area', 'label' => 'Etapa 1', 'description' => 'compre o mix' ),
			'ticket' => array('type' => 'text_area', 'label' => 'Etapa 2', 'description' => 'preencha o cupom'),
			'posting' => array('type' => 'text_area', 'label' => 'Etapa 3', 'description' => 'envie o cupom'),
			'prizes' => array('type' => 'text_area', 'label' => 'Etapa 4', 'description' => 'concorra aos prêmios'),
			'more_products' => array('type' => 'text_area', 'label' => 'Etapa 5', 'description' => 'adquira mais produtos'),
			'chances' => array('type' => 'text_area', 'label' => 'Etapa 6', 'description' => 'chances cumulativas' )
		) ;


		static function build(){
			$class = get_called_class();
			add_action('admin_init', function() use($class){
				add_action('add_meta_boxes', function() use($class){
					$screen = get_current_screen();
					if($screen->base == 'post' && $class::$post_type == $screen->post_type){
						if(isset($class::$uses['template'])){
							if($class::$post_type.'-'.$class::$uses['template'].'.php' == get_post_meta($_GET['post'], '_wp_page_template',true)){ 
								foreach ($class::$does_not_have as $feature) {
									remove_post_type_support($class::$post_type, $feature);
								}
								add_meta_box($class::$name.'-main', $class::$title , function() use ($class) {
									$object = new $class(); $presenter = get_namespace($class).'\Presenters\Base'; 
									$presenter::render('admin/defaults/metabox', array( 'type' => $class::$name, 'object' => $object, 'fields' => $class::$fields, 'custom_single' => $class ));
								}, 'page', 'normal', 'high');
							} 			
						
						}
					}
				});
				
			});
		}



		
	}

 ?>