<?php
	namespace Benedict ;  
	use CustomPost, DateTime, DateInterval ;

	class Period extends CustomPost {

		static $name = "" ;
		static $editable_by = array('form_advanced');
		static $creation_fields = array( 
			'label' => 'period','description' => 'Período promocional, que antecede um sorteio.',
			'public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post', 'map_meta_cap' => true, 
			'hierarchical' => false,'rewrite' => array('slug' => 'programacao'),'query_var' => true,
			'supports' => array('custom-fields'), 'publicly_queryable' => false,
			'has_archive' => true, 'taxonomies' => array(),
			'labels' => array (
				'name' => 'Períodos',
				'singular_name' => 'Período',
				'menu_name' => 'Períodos',
				'add_new' => 'Novo período',
				'add_new_item' => 'Cadastrar novo período',
				'edit' => 'Alterar',
				'edit_item' => 'Alterar período',
				'new_item' => 'Cadastrar período',
				'view' => 'Consultar',
				'view_item' => 'Consultar período',
				'search_items' => 'Buscar períodos',
				'not_found' => 'Nenhum período cadastrado.',
				'not_found_in_trash' => 'Nenhum período foi encontrado na lixeira.'
			)
		) ;

		static $fields = array(
			'order' => array('type' => 'integer', 'hidden' => true),
			'start_date' => array('type' => 'date', 'label' => 'Data de início', 'description' => 'início do recebimento de cupons deste período.'),
			'end_date' => array('type' => 'date', 'label' => 'Data de término', 'description' => 'término do recebimento de cupons neste período.' ),
			'lottery_date' => array('type' => 'date', 'label' => 'Data do sorteio', 'description' => 'sorteio correspondente aos cupons deste período.' ),
			'num_prizes' => array('type' => 'integer', 'label' => 'Número de prêmios', 'description' => 'o número de cupons que serão efetivamente sorteados.'),
			'announced_product' => array('type' => 'post_type', 'post_type' => 'product', 'label' => 'Produto anunciado', 'description' => 'item divulgado ao longo do período.' ),
			'prizes' => array('type' => 'array', 'hidden' => true )
		) ;

		static $collumns = array( 
			'status' => 'Estado',
			'lottery_date' => 'Data do sorteio',
			'num_registrations_overview' => 'Registros (online/físicos)'

		);

		static $actions = array(
			'download_cvs' => array('label' => 'Relatório', 'condition' => 'closed', 'capability' => 'edit_tickets' ),
			'casanova-period-statistics' => array('label' => 'Estatísticas', 'url' => '/', 'capability' => 'edit_statistics')
		);
		static $absent_collumns = array('date');
		static $absent_actions = array('quick-edit', 'view');

		static function build(){
			parent::build(); 
			$class = get_called_class();

			add_filter('title_save_pre', function($title) use($class) {
				global $post ;
				if($class::$name == $_POST['post_type'] && $post->post_status != 'publish'){
					$period_names = array('Primeiro', 'Segundo', 'Terceiro', 'Quarto');
					$num_periods = sizeof(get_posts(array('post_type' => $class::$name)));
					$title = $period_names[$num_periods];
					$_POST[$class::$name]['order'] = $num_periods +1; 
				}
				return $title ;
			}) ;


			add_action('admin_menu', function() use($class){
				add_submenu_page('edit.php?post_type=period', 'Estatísticas', 'Estatísticas', 'manage_statistics', 'casanova-period-statistics', function(){
					return print("<h2> Ainda não implementado. Aguarde!</h2>");					
				});

			});

			add_action('plugins_loaded', function() use ($class) {
				global $pagenow	;
				if($pagenow == 'edit.php' && $_GET['post_type'] == $class::$name && $_GET['action'] == 'download_cvs' ){
					$period = new static($_GET['id']);
					header('Content-type: application/x-msdownload');
					header('Content-Disposition: attachment; filename=period.csv');
					header('Pragma: no-cache;');
					header('Expires: 0');
					echo $period->online_registrations_cvs();
					exit();

				}	
			});

		}

		static function now(){
			return new DateTime('now');
		}

		public function upcoming(){
			$in_time = $this->date('start_date') > static::now()  ;
			return (bool)$in_time ;
		}

		public function started(){
			$in_time = $this->date('start_date') <= static::now()  ;
			return (bool)$in_time ;	
		}

		public function expired(){
			$end_date = $this->date('end_date');
			return (bool) ( static::now() > $end_date->add(new DateInterval('PT23H59M')) )  ;
		}

		public function done(){
			return (bool) ($this->date('lottery_date') < static::now());
		}

		public function active(){ return $this->started() && !$this->expired(); }
		public function closed(){ return $this->expired() && ! $this->done(); }

		static function all($params=array()){
			$params = array_merge(array(
				'post_type' => static::$name, 'meta_key' => 'order', 
				'orderby' => 'meta_value', 'order' => 'asc'), $params
			);
			$posts = array();
			foreach(get_posts($params) as $post){
				$posts[]= new static($post);
			}
			return $posts;
		}

		static function days_until_next_lottery(){
			foreach (static::all() as $period) {
				if($period->upcoming() || $period->started()) {
					return $period->days_until();
				}
			}
		}

		public function days_until($field='lottery_date'){
			$now = new DateTime('now'); $date = $this->date($field);
			$diff = $date->diff($now);
			return $diff->format('%a');
		}

		static function current(){
			$periods = get_posts(array('post_type' => static::$name));
			foreach ($periods as $period) {
				$period = new static($period);
				if($period->active()) return $period;
			}
			return null;
		}

		public function registrations($args=array()){
			$where = array('period_id' => $this->ID); $where = array_merge($where, $args);
			return \CasaNova\Registration::all(array('where' => $where));

		}

		public function num_registrations($args=array()){
			$where = array('period_id' => $this->ID); $where = array_merge($where, $args);
			return Registration::all(array('count' => true, 'where' => $where));
		}

		public function num_registrations_overview(){
			$total = $this->num_registrations();
			$online = $this->num_registrations(array('redeemed_by' => 'online'));
			$physical = $this->num_registrations(array('redeemed_by' => 'physical'));
			return $total . " <i>($online/$physical)</i>" ;
		}

		public function status(){
			$period = new \CasaNova\Period();
			$span = "<span style='color: %s;'>%s</span>" ;
			if($period->active()){
				return sprintf($span, 'red', 'Vigente') ;
			}
			if($period->upcoming()){
				return sprintf($span, 'gray', 'Não iniciado');
			}
			if($period->done()){
				return sprintf($span, 'green', 'Encerrado');
			}
			if($period->closed()){
				return sprintf($span, 'blue', 'Fechado');
			}
		}

		public function product(){
			return new \CasaNova\Product($this->announced_product) ;
		}

		public function online_registrations_cvs($separator = ';'){
			$file = array();
			$registrations = $this->registrations(array( 'redeemed_by' => 'online' ));
			
			# gets needed fields by merging all person info w/ ticket.
			$fields = array('ticket' => ''); 
			$fields = array_merge($fields, \CasaNova\Person::$fields);
			
			# removes uneeded fields from person.
			foreach (array('phone_backup', 'religion', 'birthdate', 'gender', 'registered_in') as $field) {
				unset($fields[$field]); 
			}

			$file[]= implode($separator, array_keys($fields));
			
			foreach ( $registrations as $registration) {
				$line = array();
				$person = \CasaNova\Person::find($registration->person_id);
				foreach ($fields as $field => $options) {
					if($field == 'ticket'){
						$value = $registration->ticket_id;
					} else {
						$value = '"'.str_replace($separator, ',', $person->$field).'"';
					}
					$line[]= $value;
				}
				$file[]= implode($separator, $line);
			}

			return implode("\n", $file);
		}
		
	}

 ?>