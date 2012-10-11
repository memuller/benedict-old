<?php 
	namespace CasaNova ;
	use DB_Object ;

	class Ticket extends DB_Object {

		static $table_sufix = 'casanova_tickets' ;
		static $pk_type = 'char(9)' ;
		static $fields = array(
			'batch_id' => array('type' => 'boolean', 'required' => true, 'index' => true),
			'printed' => array('type' => 'boolean', 'required' => true, 'default' => 0, 'index' => true),
			'redeemed' => array('type' => 'boolean', 'required' => true, 'default' => 0, 'index' => true)
		) ;

	}

?>