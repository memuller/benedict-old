<?php 
	namespace CasaNova ;
	use DB_Object ;
	class Person extends DB_Object {

		static $table_sufix = 'casanova_people' ;

		static $fields = array(
			'name' => array('required' => true) ,
			'cpf' => array('unique' => true, 'required' => true),
			'rg' => array(),
			'birthdate' => array('type' => 'date'),
			'gender' => array('type' => 'set', 'values' => array('M','F'), 'required' => true),
			'address_street' => array('required' => true),
			'address_number' => array('size' => 8, 'required' => true),
			'address_complement' => array('size' => 10),
			'address_district' => array(),
			'address_city' => array('required' => true),
			'address_state' => array('size' => 2, 'required' => true),
			'address_zip' => array('size' => 12, 'required' => true),
			
			'email' => array('size' => 255),
			'phone_main' => array('size' => 16), 
			'phone_backup' => array('size' => 16),
			'phone_mobile' => array('size' => 16),

			'religion' => array(),

			'wants_newsletter' => array('type' => 'set', 'values' => array('email', 'sms')),

			'registered_in' => array('required' => true, 'type' => 'datetime', 'mechanized' => array('date', 'Y-m-d H:i:s'))
		) ;
	}

?>