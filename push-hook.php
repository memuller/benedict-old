<?php
	error_reporting(0);

	try {
		$payload = json_decode($_REQUEST['payload']);
	} catch(Exception $e){
		exit(0);
	}

	if($payload->ref == 'refs/heads/master'){
		`git pull origin master`
	}
?>