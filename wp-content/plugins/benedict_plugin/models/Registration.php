<?php 
	namespace CasaNova ;
	use DB_Object ;

	class Registration extends DB_Object {

		static $table_sufix = 'casanova_registrations' ;
		static $fields = array(
			'ticket_id' => array('type' => 'char(9)', 'required' => true),
			'person_id' => array('type' => 'bigint(20) unsigned', 'required' => false  ),
			'period_id' => array('type' => 'bigint(20) unsigned', 'required' => true),
			'redeemed_at' => array('type' => 'timestamp', 'required' => true, 'mechanized' => array('date', 'Y-m-d H:i:s'), 'mechanize_once' => true),
			'redeemed_by' => array('type' => 'set', 'values' => array('online', 'physical'), 'default' => 'online', 'required' => true)
		) ;


		static function build(){
			parent::build();
			$class = get_called_class();

			add_action('admin_menu', function() use($class){
				add_menu_page('Cadastros', 'Cadastros', 'edit_statistics', 'casanova-registration', function() use($class){
					return print("<h2> Ainda não implementado. Aguarde!</h2>");
				}, null, 24);

				if(Period::current()){
					add_submenu_page('casanova-registration', 'Cadastrar cupom físico', 'Cadastrar', 'edit_registrations', 'casanova-registration-register', function(){
						return \CasaNova\Presenters\Registration::index();
					});
				}
			});
		}

	}

?>