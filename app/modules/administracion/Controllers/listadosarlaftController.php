<?php

/**

* Controlador de Listadosarlaft que permite la  creacion, edicion  y eliminacion de los Listado Sarlaft del Sistema

*/

class Administracion_listadosarlaftController extends Administracion_mainController

{

	/**
	 * $mainModel  instancia del modelo de  base de datos Listado Sarlaft
	 * @var modeloContenidos
	 */

	public $mainModel;

	/**
	 * $route  url del controlador base
	 * @var string
	 */

	protected $route;

	/**
	 * $pages cantidad de registros a mostrar por pagina]
	 * @var integer
	 */

	protected $pages ;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */

	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */

	protected $_csrf_section = "administracion_listadosarlaft";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */

	protected $namepages;


	/**
     * Inicializa las variables principales del controlador listadosarlaft .
     *
     * @return void.
     */

	public function init()

	{
		$this->mainModel = new Administracion_Model_DbTable_Listadosarlaft();
		$this->namefilter = "parametersfilterlistadosarlaft";
		$this->route = "/administracion/listadosarlaft";
		$this->namepages ="pages_listadosarlaft";
		$this->namepageactual ="page_actual_listadosarlaft";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}

		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  Listado Sarlaft con sus respectivos filtros.
     *
     * @return void.
     */

	public function indexAction()

	{

		$title = "Administración de Listado Sarlaft";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = " fecha DESC ";
		$list = $this->mainModel->getList($filters,$order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page && Session::getInstance()->get($this->namepageactual)) {
		   	$page = Session::getInstance()->get($this->namepageactual);
		   	$start = ($page - 1) * $amount;
		} else if(!$page){
			$start = 0;
		   	$page=1;
			Session::getInstance()->set($this->namepageactual,$page);
		} else {
			Session::getInstance()->set($this->namepageactual,$page);
		   	$start = ($page - 1) * $amount;
		}

		$this->_view->register_number = count($list);
		$this->_view->pages = $this->pages;
		$this->_view->totalpages = ceil(count($list)/$amount);
		$this->_view->page = $page;
		$this->_view->lists = $this->mainModel->getListPages($filters,$order,$start,$amount);
		$this->_view->csrf_section = $this->_csrf_section;

	}


	public function detalleAction()

	{

	}



	/**
     * Genera la Informacion necesaria para editar o crear un  Listado Sarlaft  y muestra su formulario
     *
     * @return void.

     */

	public function manageAction()

	{

		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_listadosarlaft_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");

		if ($id > 0) {

			$content = $this->mainModel->getById($id);

			if($content->id){

				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar Listado Sarlaft";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;

			}else{

				$this->_view->routeform = $this->route."/insert";
				$title = "Crear Listado Sarlaft";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;

			}

		} else {

			$this->_view->routeform = $this->route."/insert";
			$title = "Crear Listado Sarlaft";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;

		}

	}



	/**

     * Inserta la informacion de un Listado Sarlaft  y redirecciona al listado de Listado Sarlaft.

     *

     * @return void.

     */

	public function insertAction(){

		$this->setLayout('blanco');

		$csrf = $this->_getSanitizedParam("csrf");

		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {

			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR LISTADO SARLAFT';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);

		}

		header('Location: '.$this->route.''.'');

	}



	/**

     * Recibe un identificador  y Actualiza la informacion de un Listado Sarlaft  y redirecciona al listado de Listado Sarlaft.

     *

     * @return void.

     */

	public function updateAction(){

		$this->setLayout('blanco');

		$csrf = $this->_getSanitizedParam("csrf");

		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->id) {
				$data = $this->getData();
				$this->mainModel->update($data,$id);
			}

			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR LISTADO SARLAFT';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}

		header('Location: '.$this->route.''.'');

	}



	/**

     * Recibe un identificador  y elimina un Listado Sarlaft  y redirecciona al listado de Listado Sarlaft.

     *

     * @return void.

     */

	public function deleteAction()

	{

		$this->setLayout('blanco');

		$csrf = $this->_getSanitizedParam("csrf");

		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf ) {

			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR LISTADO SARLAFT';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }

			}

		}

		header('Location: '.$this->route.''.'');

	}



	/**

     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Listadosarlaft.

     *

     * @return array con toda la informacion recibida del formulario.

     */

	private function getData()

	{

		$data = array();
		$data['cedula'] = $this->_getSanitizedParam("cedula");
		$data['fecha'] = $this->_getSanitizedParam("fecha");

		return $data;

	}

	/**

     * Genera la consulta con los filtros de este controlador.

     *

     * @return array cadena con los filtros que se van a asignar a la base de datos

     */

    protected function getFilter()
    {

    	$filtros = " 1 = 1 ";

        if (Session::getInstance()->get($this->namefilter)!="") {

            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->cedula != '') {
                $filtros = $filtros." AND cedula LIKE '%".$filters->cedula."%'";
            }
            if ($filters->fecha != '') {
                $filtros = $filtros." AND fecha LIKE '%".$filters->fecha."%'";
            }
            if ($filters->nombres != '') {
                $filtros = $filtros." AND usuarios_info.nombres LIKE '%".$filters->nombres."%'";
            }
            if ($filters->apellidos != '') {
                $filtros = $filtros." AND usuarios_info.apellidos LIKE '%".$filters->apellidos."%'";
            }

		}
        return $filtros;
    }


    /**
     * Recibe y asigna los filtros de este controlador
     *
     * @return void
     */

    protected function filters()
    {
        if ($this->getRequest()->isPost()== true) {

        	Session::getInstance()->set($this->namepageactual,1);

            $parramsfilter = array();
			$parramsfilter['cedula'] =  $this->_getSanitizedParam("cedula");
			$parramsfilter['fecha'] =  $this->_getSanitizedParam("fecha");
			$parramsfilter['nombres'] =  $this->_getSanitizedParam("nombres");
			$parramsfilter['apellidos'] =  $this->_getSanitizedParam("apellidos");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
        }

        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }

    }


	public function actualizarnombresAction()
	{

		$usuariosinfoModel = new Administracion_Model_DbTable_Usuariosinfo();
		$usuariospaginaModel = new Page_Model_DbTable_Usuarios();


		$list = $usuariosinfoModel->getList("","");
		foreach ($list as $key => $value) {
			$nombres = $value->nombres;
			$apellidos = $value->apellidos;
			$cedula = $value->documento;
			$usuariopagina = $usuariospaginaModel->getList(" user_idnumber='$cedula' ","")[0];

			//echo $cedula."<br>";

			if($nombres==""){
				echo $cedula."<br>";
				$nombres1= trim($usuariopagina->user_names);
				$nombres1 = str_replace("  "," ",$nombres1);
				if($nombres1!=""){
					echo "nombres completo: ".$nombres1."<br>";
					$aux = explode(" ",$nombres1);
					if(count($aux)==4){
						$nombres1 = $aux[2]." ".$aux[3];
					}
					if(count($aux)==3){
						$nombres1 = $aux[2];
					}
					echo "nombres: ".$nombres1."<br>";
					$usuariosinfoModel->editField($cedula,"nombres",$nombres1);
				}
			}

			if($apellidos=="" or $apellidos==" "){
				echo $cedula."<br>";
				$apellidos1= trim($usuariopagina->user_lastnames);
				$apellidos1 = str_replace("  "," ",$apellidos1);
				if($apellidos1!=""){
					echo "apellidos completo: ".$apellidos1."<br>";
					$aux = explode(" ",$apellidos1);
					if(count($aux)==4){
						$apellidos1 = $aux[2]." ".$aux[3];
					}
					if(count($aux)==3){
						$apellidos1 = $aux[2];
					}
					echo "apellidos: ".$apellidos1."<br>";
					$usuariosinfoModel->editField($cedula,"apellidos",$apellidos1);
				}

				$apellidos1= trim($usuariopagina->user_names);
				$apellidos1 = str_replace("  "," ",$apellidos1);
				if($apellidos1!=""){
					echo "apellidos completo2: ".$apellidos1."<br>";
					$aux = explode(" ",$apellidos1);
					if(count($aux)==4){
						$apellidos1 = $aux[0]." ".$aux[1];
					}
					if(count($aux)==3){
						$apellidos1 = $aux[0]." ".$aux[1];
					}
					if(count($aux)==2){
						$apellidos1 = $aux[0];
					}
					echo "apellidos2: ".$apellidos1."<br>";
					$usuariosinfoModel->editField($cedula,"apellidos",$apellidos1);
				}

			}

		}

	}


	public function exportarAction()
	{

		$this->setLayout('blanco');
		$hoy = date("YmdHis");
		$excel = $this->_getSanitizedParam("excel");
		if($excel==1){
			header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
			header("Content-type:   application/x-msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=listado-sarlaft-".$hoy.".xls");
		}

		$listado = $this->mainModel->getList("","");
		$beneficiariosModel = new Administracion_Model_DbTable_Beneficarios();
		$hijosModel = new Administracion_Model_DbTable_Hijos();
		foreach ($listado as $key => $value) {
			$cedula = $value->documento;
			$value->beneficiarios = $beneficiariosModel->getList(" asociado='$cedula' ","");
			$value->hijos = $hijosModel->getList(" asociado='$cedula' ","");
		}
		$this->_view->listado = $listado;


		$ciudadModel = new Administracion_Model_DbTable_Ciudad();
		$ciudades = $ciudadModel->getList(""," nombre ASC ");
		$array_ciudades = array();
		foreach ($ciudades as $key => $value) {
			$array_ciudades[$value->codigo]=$value->nombre;
		}
		$this->_view->array_ciudades = $array_ciudades;

	}

}