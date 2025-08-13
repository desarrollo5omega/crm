<?php
/**
* Controlador de 403 que permite la  creacion, edicion  y eliminacion de los 403 del Sistema
*/
class Page_403Controller extends Page_mainController
{
	
    public $botonpanel = 8;

	public function indexAction()
	{
		$title = "Pagina Restringida";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
	}

	
}