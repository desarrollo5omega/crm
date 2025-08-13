<?php
/**
* Controlador de Importarahorros que permite la  creacion, edicion  y eliminacion de los importar aportes y ahorros del Sistema
*/
class Administracion_importarahorrosController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos importar aportes y ahorros
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
	protected $_csrf_section = "administracion_importarahorros";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador importarahorros .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Importarahorros();
		$this->namefilter = "parametersfilterimportarahorros";
		$this->route = "/administracion/importarahorros";
		$this->namepages ="pages_importarahorros";
		$this->namepageactual ="page_actual_importarahorros";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  importar aportes y ahorros con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de importar aportes y ahorros";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "";
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

	/**
     * Genera la Informacion necesaria para editar o crear un  importar aportes y ahorros  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_importarahorros_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar importar aportes y ahorros";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear importar aportes y ahorros";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear importar aportes y ahorros";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un importar aportes y ahorros  y redirecciona al listado de importar aportes y ahorros.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$uploadDocument =  new Core_Model_Upload_Document();
			if($_FILES['archivo3']['name'] != ''){
				$data['archivo3'] = $uploadDocument->upload("archivo3");
			}
			$id = $this->mainModel->insert($data);
			
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR IMPORTAR APORTES Y AHORROS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un importar aportes y ahorros  y redirecciona al listado de importar aportes y ahorros.
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
					$uploadDocument =  new Core_Model_Upload_Document();
				if($_FILES['archivo3']['name'] != ''){
					if($content->archivo3){
						$uploadDocument->delete($content->archivo3);
					}
					$data['archivo3'] = $uploadDocument->upload("archivo3");
				} else {
					$data['archivo3'] = $content->archivo3;
				}
				$this->mainModel->update($data,$id);
			}
			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR IMPORTAR APORTES Y AHORROS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
			header('Location:/administracion/importarahorros/carga');
	}
		public function cargaAction()
	{
		$this->setLayout('blanco');
		$id = 1;
		$content = $this->mainModel->getById($id);
		$archivo = $content->archivo3;
		$this->getLayout()->setTitle("Importar cupos");

		//leer archivo
    	ini_set('memory_limit', '-1');
    	ini_set('max_execution_time', 300);
    	$inputFileName = FILE_PATH.'/'.$archivo;
   		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		$infoexel = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$ahorrosModel = new Administracion_Model_DbTable_Ahorrosaportes();

		//$ahorrosModel->vaciar();
		$i=0;
//print_r($infoexel);
		foreach ($infoexel as $fila) {

			$i++;
			//echo $i;
			if($i>1){
				

				$cedula = $fila[E];
				$existe=$ahorrosModel->getList("cedula LIKE '%".$cedula."%'","")[0];
				if(count($existe)==0){
				$dataAhorros['cedula'] = $cedula;
				if($fila[G] == "AHORRO PERMANENTE"){
				 $dataAhorros['ahorros'] = (double)$fila[F];
				 $dataAhorros['aportes'] = 0;
				}
				if($fila[G] == "APORTES ORDINARIOS"){
				$dataAhorros['aportes'] = (double)$fila[F];
				$dataAhorros['ahorros'] = 0;
				}
				$dataAhorros['ahorrovol'] = 0;				
				if($cedula!=""){
						$ahorrosModel->insert($dataAhorros);

				}
			}else{
				if($fila[G] == "AHORRO PERMANENTE"){
				$ahorrosModel->editField($existe->id,"ahorro",(double)$fila[F]);
				}
				if($fila[G] == "APORTES ORDINARIOS"){
				$ahorrosModel->editField($existe->id,"aportes",(double)$fila[F]);
				}
			}

			}
		}

		header("Location:/administracion/importarahorros/");
	}

	/**
     * Recibe un identificador  y elimina un importar aportes y ahorros  y redirecciona al listado de importar aportes y ahorros.
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
					$uploadDocument =  new Core_Model_Upload_Document();
					if (isset($content->archivo3) && $content->archivo3 != '') {
						$uploadDocument->delete($content->archivo3);
					}
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR IMPORTAR APORTES Y AHORROS';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Importarahorros.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['archivo'] = $this->_getSanitizedParam("archivo");
		$data['archivo2'] = $this->_getSanitizedParam("archivo2");
		$data['archivo3'] = '';
		$data['archivo4'] = $this->_getSanitizedParam("archivo4");
		$data['archivo_inactivos'] = $this->_getSanitizedParam("archivo_inactivos");
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
            if ($filters->archivo3 != '') {
                $filtros = $filtros." AND archivo3 LIKE '%".$filters->archivo3."%'";
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
					$parramsfilter['archivo3'] =  $this->_getSanitizedParam("archivo3");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}