<?php  
	namespace CasaNova\Presenters ;
	use Presenter ; 

	class Registration extends Presenter {

		static $uses = array('styles', 'scripts', 'admin_scripts');

		static function admin_scripts(){
			if('casanova-registration-register' == $_GET['page']){
				wp_enqueue_script('casanova-registration-register', static::url('js/admin/registration.js'));
			}
		}

		static function scripts(){
			if(is_page('cadastro')){
					wp_enqueue_script('casanova-registration-register', static::url('js/registration.js'), array('jquery'));
					wp_enqueue_script( 'jquery-validate', static::url( 'js/jquery-validate/jquery.validate.min.js'), array('jquery') );
					wp_enqueue_script( 'jquery-validate-br', static::url( 'js/jquery-validate/brazilian.methods.js'), array('jquery-validate') );
					wp_enqueue_script( 'jquery-maskedinput', static::url('js/jquery-maskedinput/jquery.maskedinput.js'), array('jquery') );
					wp_enqueue_script( 'jquery-cep', static::url('js/jquery-cep/jquery.cep-1.0.min.js'), array('jquery') );	
			}
		}

		static function index(){
			if(is_admin()){
				if('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'register_physical' ){
					$period = \CasaNova\Period::current(); $code = strtoupper($_POST['registration']['ticket']); $error = false;
					$ticket = \CasaNova\Ticket::find($code);
					
					if(!$ticket)
						return static::render('admin/registration/physical', array('error' => 'invalid'));
					
					if( $ticket->redeemed == true )
						return static::render('admin/registration/physical', array('error' => 'consumed'));

					$ticket->redeemed = true; $ticket->persist();
					$registration = new \CasaNova\Registration(array('ticket_id' => $ticket->id, 'period_id' => $period->ID, 'redeemed_by' => 'physical' ));
					
					return static::render('admin/registration/physical', array('success' => true));

				}
				return static::render('admin/registration/physical');	
			} else {
				if('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'register_online' ){
					$period = \CasaNova\Period::current(); 
					if(!$period) wp_die('The campaign is already over. Sorry.');
					$registration = $_POST['registration']; $person = $_POST['person'];

					$recaptcha = recaptcha_check_answer( RECAPTCHA_PRIVATE_KEY, $_SERVER['REMOTE_ADDR'], 
						$_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field'] );
					if(!$recaptcha->is_valid){
						return static::render('registration/index', array('errors' => true, 'person' => $person));
					}

					
					$ticket = implode('', $registration['ticket']); $ticket = strtoupper($ticket);
					$ticket = \CasaNova\Ticket::find($ticket);
					if(!$ticket || $ticket->redeemed == true) {
						$error_page = get_posts(array('post_type' => 'page', 'pagename' => 'cupom-invalido'));
						return static::render('registration/error', array('text' => $error_page[0]->post_content));
					}
					$person['wants_newsletter'] = implode(',', $persons['wants_newsletter']);
					$person = \CasaNova\Person::find_or_create($person);

					$ticket->redeemed = true ; $ticket->persist();
					$registration = new \CasaNova\Registration(array(
						'ticket_id' => $ticket->id, 'period_id' => $period->ID, 
						'person_id' => $person->id, 'redeemed_by' => 'online'
					));
					$success_page = get_posts(array('post_type' => 'page', 'pagename' => 'sucesso'));
					return static::render('registration/success', array('person' => $person, 'text' => $success_page[0]->post_content));
					
				} else {
					return static::render('registration/index');	
				}
				

			}
			
		}



	}
?>