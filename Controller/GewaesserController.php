<?php

namespace MVC\Controller;

use MVC\Library\View;
use MVC\Library\Formular;
use MVC\Controller\ControllerBase;
use MVC\Controller\Controller;
use MVC\Model\Gewaesser;
use MVC\Model\GewaesserTyp;

class GewaesserController extends ControllerBase implements Controller{
	
	public function setView(View $view){
		$this->view = $view;
	}
	
	public function indexAction(){
		$gewaesser = Gewaesser::find(array('criteria' => '1 ORDER BY bezeichnung ASC'));
		$gewaesserTypen = GewaesserTyp::find(array('criteria' => 1));
		$typ = [];
		foreach($gewaesserTypen as $key => $val){
			$typ[$val->id] = $val->bezeichnung;
		}
		
		$this->view->setVars(array(
			'title'				=> "Gewässer",
			'gewaesser'			=> $gewaesser,
			'gewaessertypen'	=> $gewaesserTypen,
			'typ'				=> $typ
		));
	}
	
	public function infoAction(){
		
	}
	
	public function bearbeitenAction(){
		if(isset($_POST) && $_POST["action"] === "save"){
			$id = (int)$_POST["id"];
			$gewaesser = Gewaesser::loadFromArray($_POST);
			$gewaesser->save();
			header("Location: ./");
		}
		
		if(isset($_GET) && count($_GET) > 0){
			$id = (int)$_GET["id"];
			$gewaesser = Gewaesser::findFirst($id);

			$form = new Formular();

			$gewaesserTypen = GewaesserTyp::find(array('criteria' => 1));
			$this->view->setVars(array(
				'title'				=> "Gewässer bearbeiten",
				'gewaessertypen'	=> $gewaesserTypen,
				'gewaesser'			=> $gewaesser,					
				'form'				=> $form
			));
		}else{
			throw new Exception("Fehlender Parameter");
		}
	}
	
	public function loeschenAction(){
		if(isset($_GET) && count($_GET) > 0){
			$id = (int)$_GET["id"];
			$gewaesser = Gewaesser::findFirst($id);
			$gewaesser->del();
			header("Location: ./");
		}else{
			throw new Exception("Falsche Parameter");
		}
	}
	
	public function hinzufuegenAction(){
		if(isset($_POST) && count($_POST) > 0){
			$gewaesser = Gewaesser::loadFromArray($_POST);
			$gewaesser->save();
			header("Location: ./");
		}
		
		$form = new Formular();
		
		$gewaesserTypen = GewaesserTyp::find(array('criteria' => 1));
		$this->view->setVars(array(
			'title'				=> "Gewässer hinzufügen",
			'gewaessertypen'	=> $gewaesserTypen,
			'form'				=> $form
		));
	}
	
	
	
	
	
}