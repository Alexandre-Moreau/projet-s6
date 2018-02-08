<?php

//Auto-generated file
class SiteController extends Controller{

	public function index(){
		$this->render("index");
	}

	public function rechercher(){
		$data['onto'] = Concept::findAllWithChildrens();
		$this->render("rechercher", $data);
	}

	public function creerOntoterminologie(){
		$this->render("formCreerOntoterminologie");
	}
	
}

?>