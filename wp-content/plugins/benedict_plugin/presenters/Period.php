<?php  
	namespace CasaNova\Presenters ;
	use Presenter ; 

	class Period extends Presenter {

		static $uses = array('admin_scripts');
		static $presents_for = '\CasaNova\Period' ;

		static function build(){
			parent::build(); $class = static::$presents_for; $presenter = get_called_class();
			add_action('edit_form_advanced', function() use($class, $presenter) {
					$screen = get_current_screen() ; 
					if($screen->post_type == $class::$name){
						$period = new $class();
						if($period->num_prizes > 0){
							$presenter::render('admin/period/prizes', array('period' => $period));
						}
					}
				});

		}

		static function admin_scripts(){
		}

		static function index(){

			
		}



	}
?>