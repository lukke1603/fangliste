<?php

namespace MVC\Controller;

use MVC\Library\View;
use MVC\Model\Fangliste;
use MVC\Model\Gewaesser;
use MVC\Model\Fischarten;
use MVC\Model\Koeder;
use MVC\Model\FanglisteBilder;
use MVC\Library\Filer;

class FanglisteController extends ControllerBase implements Controller{
	
	public function setView(View $view){
		$this->view = $view;
	}
	
	public function hinzufuegenAction(){
		if(isset($_FILES) && isset($_FILES["bilder"])){
			$files = Filer::convertFileArray($_FILES["bilder"]);
			foreach($files as $key => $val){
				if(!  file_exists(PATH_USER_IMAGES.$val["name"])){
					move_uploaded_file($val["tmp_name"], PATH_USER_IMAGES.$val["name"]);
//					copy($val["tmp_name"], PATH_USER_IMAGES.$val["name"]);
				}
			}
			
			echo json_encode(array("name" => $val["name"], "type" => $val["type"]));
			exit;
		}
		
		if(isset($_POST) && count($_POST) > 0){
			$fangliste = Fangliste::loadFromArray($_POST);
			$fangliste->datum = $_POST["datum"] . " " . $_POST["uhrzeit"] . ":00";
			$fangliste->save();
			
			if(isset($_POST["bilderliste"]) && count($_POST["bilderliste"]) > 0){
				$bilder = json_decode($_POST["bilderliste"], true);
				foreach($bilder as $key => $val){
					if(file_exists(PATH_USER_IMAGES.$val["name"])){
						$fanglisteBilder = FanglisteBilder::loadFromArray(array("name"=>$val["name"], "fangliste"=>$fangliste->id, "type"=>$val["type"], "pfad"=>PATH_USER_IMAGES_REL.$val["name"]));
						$fanglisteBilder->save();
					}
				}
			}
			header("Location: ./");
		}
		
		
		$gewaesser = Gewaesser::find(array('criteria'=>1));
		$fischarten = Fischarten::find(array('criteria'=>1));
		$koeder = Koeder::find(array('criteria'=>1));
		
		$this->view->setVars(array(
			'title'=>"Fang hinzufügen",
			'user'=>$this->user,
			'gewaesser'=>$gewaesser,
			'fischarten'=>$fischarten,
			'koeder'=>$koeder
		));
	}
	
	
	public function indexAction(){
		$faenge = Fangliste::find(array('criteria'=>'1 ORDER BY datum DESC'));
		$gewaesser = Gewaesser::find(array('criteria'=>1));
		$fischarten = Fischarten::find(array('criteria'=>1));
		
		$gewaesserIndizes = [];
		foreach($gewaesser as $key => $obj){
			$gewaesserIndizes[$obj->id] = $obj->bezeichnung;
		}
		
		$fischartenIndizes = [];
		foreach($fischarten as $key => $obj){
			$fischartenIndizes[$obj->id] = $obj->name;
		}
		
		
		$this->view->setVars(array(
			'title'=>"Fangliste",
			'faenge' => $faenge,
			'gewaesserIndizes' => $gewaesserIndizes,
			'fischartenIndizes' => $fischartenIndizes
		));
	}
	
	
	public function loeschenAction(){
		if(isset($_GET) && count($_GET) > 0){
			$id = (int)$_GET["id"];
			
			$bilder = FanglisteBilder::find(array('criteria'=>'fangliste = :fangliste', 'bind' => array(':fangliste'=>$id)));
			foreach($bilder as $key => $bild){
				$bild->del();
			}
			
			$fang = Fangliste::findFirst($id);
			$fang->del();
			header("Location: ./");
		}else{
			throw new Exception("Falsche Parameter");
		}
	}
	
	
	public function detailsAction(){
		if(isset($_GET) && count($_GET) > 0){
			$id = (int)$_GET["id"];
			$fang = Fangliste::findFirst($id);
			$gewaesser = Gewaesser::findFirst((int)$fang->gewaesser);
			$koeder = Koeder::findFirst((int)$fang->koeder);
			$fischart = Fischarten::findFirst((int)$fang->fischart);
			$images = FanglisteBilder::find(array(
				'criteria' => 'fangliste = :fangliste',
				'bind' => array(
					':fangliste' => $id
				)
			));
		
			$this->view->setVars(array(
				'title' => 'Fangliste',
				'fang' => $fang,
				'gewaesser' => $gewaesser,
				'fischart' => $fischart,
				'koeder' => $koeder,
				'images' => $images
			));
		}else{
			throw new Exception("Falsche Parameter");
		}
		
	}
	
	
}
