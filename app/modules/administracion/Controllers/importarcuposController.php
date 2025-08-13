<?php
/**
* Controlador de Importarcupos que permite la  creacion, edicion  y eliminacion de los importar cupos del Sistema
*/
class Administracion_importarcuposController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos importar cupos
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
	protected $_csrf_section = "administracion_importarcupos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador importarcupos .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Importarcupos();
		$this->namefilter = "parametersfilterimportarcupos";
		$this->route = "/administracion/importarcupos";
		$this->namepages ="pages_importarcupos";
		$this->namepageactual ="page_actual_importarcupos";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  importar cupos con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de importar cupos";
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
     * Genera la Informacion necesaria para editar o crear un  importar  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_importarcupos_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar importar";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear importar";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear importar";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un importar  y redirecciona al listado de importar cupos.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$uploadDocument =  new Core_Model_Upload_Document();
			if($_FILES['archivo']['name'] != ''){
				$data['archivo'] = $uploadDocument->upload("archivo");
			}
			$id = $this->mainModel->insert($data);
			
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR IMPORTAR';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un importar  y redirecciona al listado de importar cupos.
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
					
				if($_FILES['archivo']['name'] != ''){
					if($content->archivo){
						$uploadDocument->delete($content->archivo);
					}
					$data['archivo'] = $uploadDocument->upload("archivo");
				
				} else {
					$data['archivo'] = $content->archivo;
				}
				$this->mainModel->update($data,$id);
			}
			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR IMPORTAR';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		//header('Location: '.$this->route.''.'');
		header('Location:/administracion/importarcupos/carga');
	}


	public function cargaAction()
	{
		$id = 1;
		$content = $this->mainModel->getById($id);
		$archivo = $content->archivo;
		$this->getLayout()->setTitle("Importar saldos");
		//leer archivo
    	ini_set('memory_limit', '-1');
    	ini_set('max_execution_time', 300);
    	$inputFileName = FILE_PATH.'/'.$archivo;
   		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		$infoexel = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$saldosModel = new Page_Model_DbTable_Saldos();
		$saldosModel->vaciar();
		$i=0;
//print_r($infoexel);
		foreach ($infoexel as $fila) {
			$i++;
			if($i>1){

				$cedula = $data['estadocuenta_saldos_cedula'] = $fila[B];
				$codlinea = $data['estadocuenta_saldos_linea'] = $fila[S];
				$linea = $data['linea'] = $fila[R];
				$monto = $data['monto'] = (double)$fila[T];
				$plazo = $data['plazo'] = (int)$fila[U];
				$data['saldoactual'] = (double)$fila[Z];
				$data['saldomora'] = (double)$fila[AK];
				$data['fhaprcita'] = $fila[D];
				$data['vence'] = $fila[E];
				$data['ncuotas'] = (int)$fila[G];
				$data['cuotafija'] = (double)$fila[I];
				$data['pagare'] = (double)$fila[Q];
				$data['valormora'] = (double)$fila[AU];
				$data['capitalmora'] = (double)$fila[AV];

				if($cedula!=""){
					/*$existe = $saldosModel->getList("estadocuenta_saldos_cedula='$cedula' ","");
					if(count($existe)==0){*/
						$saldosModel->insert($data);
					/*}else{
						$id = $existe[0]->id;
						if($nombre!=""){
							$cuposModel->editField($id,"nombre",$nombre);
						}
						if($linea!=""){
							$cuposModel->editField($id,"linea",$linea);
						}
						if($cupo!=""){
							$cuposModel->editField($id,"cupo",$cupo);
						}
						if($saldo_actual!=""){
							$cuposModel->editField($id,"saldo_actual",$saldo_actual);
						}
					}*/
				}

			}
		}

		header("Location:/administracion/importarcupos/");
	}

	/**
     * Recibe un identificador  y elimina un importar  y redirecciona al listado de importar cupos.
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
					if (isset($content->archivo) && $content->archivo != '') {
						$uploadDocument->delete($content->archivo);
					}
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR IMPORTAR';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Importarcupos.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['archivo'] = '';
		$data['archivo2'] = $this->_getSanitizedParam("archivo2");
		$data['archivo3'] = $this->_getSanitizedParam("archivo3");
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
            if ($filters->archivo != '') {
                $filtros = $filtros." AND archivo LIKE '%".$filters->archivo."%'";
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
					$parramsfilter['archivo'] =  $this->_getSanitizedParam("archivo");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}