<?php
	
namespace MVC\Controller;

use MVC\Model\User;
use MVC\Library\NotFoundException;
use MVC\Library\View;

class IndexController extends ControllerBase implements Controller{

	protected $view;

	public function setView(View $view){
		$this->view = $view;
	}

	public function indexAction(){
		$this->view->setVars([
			'name' => 'Lukas'
		]);
	}
	
	
}

	