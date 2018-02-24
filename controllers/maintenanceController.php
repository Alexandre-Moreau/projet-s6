<?php

//Auto-generated file
class MaintenanceController extends Controller{

	public function statut(){
		$data = [];
		$data['serverUser'] = exec('whoami');
		//http://itman.in/en/how-to-get-client-ip-address-in-php/
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			//check ip from share internet
			$data['ipClient'] = $_SERVER['HTTP_CLIENT_IP'];
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//to check ip is pass from proxy
			$data['ipClient'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$data['ipClient'] = $_SERVER['REMOTE_ADDR'];
			if($data['ipClient'] == '::1'){
				$data['ipClient'] .= ' (localhost)';
			}
		}
		
		$data['ipServeur'] = $_SERVER['SERVER_ADDR'].':'.$_SERVER['SERVER_PORT'];
		
		// - Articles dans la bdd mais pas sur le disque
		
		// - Articles sur le disque non référencés
		
		$this->render("index",$data);
	}

	// Pouvoir tout re-référencer, ou juste certains articles
	
}

?>
