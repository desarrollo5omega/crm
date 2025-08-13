<?php
/**
* Controlador de Importarasociados que permite la  creacion, edicion  y eliminacion de los importar asociados del Sistema
*/
class Administracion_importartercerosController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos importar asociados
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
	protected $_csrf_section = "administracion_importarasociados";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador importarasociados .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Importarasociados();
		$this->namefilter = "parametersfilterimportarasociados";
		$this->route = "/administracion/importarterceros";
		$this->namepages ="pages_importarasociados";
		$this->namepageactual ="page_actual_importarasociados";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  importar asociados con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de importar terceros";
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
     * Genera la Informacion necesaria para editar o crear un  importar asociados  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_importarasociados_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar importar terceros";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear importar terceros";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear importar terceros";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un importar asociados  y redirecciona al listado de importar asociados.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$data = $this->getData();
			$uploadDocument =  new Core_Model_Upload_Document();
			if($_FILES['archivo_terceros']['name'] != ''){
				$data['archivo_terceros'] = $uploadDocument->upload("archivo_terceros");
			}
			$id = $this->mainModel->insert($data);
			$data['id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR IMPORTAR TERCEROS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un importar asociados  y redirecciona al listado de importar asociados.
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
				if($_FILES['archivo_terceros']['name'] != ''){
					if($content->archivo_terceros){
						$uploadDocument->delete($content->archivo_terceros);
					}
					$data['archivo_terceros'] = $uploadDocument->upload("archivo_terceros");
				} else {
					$data['archivo_terceros'] = $content->archivo_terceros;
				}
				$this->mainModel->update($data,$id);
			}
			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR IMPORTAR TERCEROS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		//header('Location: '.$this->route.''.'');
		header('Location:/administracion/importarterceros/carga/');
	}


	public function cargaAction()
	{
		$id = 1;
		$content = $this->mainModel->getById($id);
		$archivo = $content->archivo_terceros;
		$this->getLayout()->setTitle("Importar terceros");

		//leer archivo
    	ini_set('memory_limit', '-1');
    	ini_set('max_execution_time', 300);
    	$inputFileName = FILE_PATH.'/'.$archivo;
   		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		$infoexel = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$cedulasModel = new Administracion_Model_DbTable_Usuariosinfo();
		$ciudadModel = new Administracion_Model_DbTable_Ciudad();
		$i=0;

		foreach ($infoexel as $fila) {
			$i++;
			if($i>1){

				$documento = $data['documento'] = $fila[A]*1;

				$nombres = $fila[E];
				$aux = explode(" ",$nombres);

				$nombres = $data['nombres'] = $aux[2]." ".$aux[3];
				$apellidos = $data['apellidos'] = $aux[0]." ".$aux[1];

				$data['direccion'] = $fila[N];
				$data['celular'] = $fila[R];
				$data['email'] = $fila[S];
				$data['telefono'] = $fila[T];

				$data['fecha_ingreso'] = str_replace(".","-",$fila[F]);
				$data['fecha_nacimiento'] = str_replace(".","-",$fila[G]);
				$data['fecha_documento'] = str_replace(".","-",$fila[BH]);
				$data['genero'] = $fila[AL];
				if($data['genero']=="M"){
					$data['genero']="Masculino";
				}
				if($data['genero']=="F"){
					$data['genero']="Femenino";
				}

				$data['tipo_documento'] = $fila[B];
				if($data['tipo_documento']=="C"){
					$data['tipo_documento']="CC";
				}
				if($data['tipo_documento']=="E"){
					$data['tipo_documento']="CE";
				}

				$data['barrio'] = $fila[AT];
				$ciudad_documento = $fila[BA];
				$ciudad_documento = substr($ciudad_documento,0,3);
				$ciudad_list = $ciudadModel->getList(" nombre LIKE '%$ciudad_documento%' ","")[0];
				$data['ciudad_documento'] = $ciudad_list->codigo;

				$estado_civil = $fila[AX];
				if($estado_civil=="C"){
					$data['estado_civil'] = "Casado(a)";
				}
				if($estado_civil=="S"){
					$data['estado_civil'] = "Soltero(a)";
				}
				if($estado_civil=="V"){
					$data['estado_civil'] = "Viudo(a)";
				}
				if($estado_civil=="U"){
					$data['estado_civil'] = "Union libre";
				}

				$data['empresa'] = $fila[X];
				$data['direccion_oficina'] = $fila[BB];
				$data['telefono_oficina'] = $fila[BC];
				$data['fecha_afiliacion'] = str_replace(".","-",$fila[Z]);

				$data['cuenta_tipo'] = strtoupper($fila[AK]);
				$data['cuenta_numero'] = $fila[AI];
				$data['entidad_bancaria'] = $fila[AJ];


				if($data['documento']!=""){
					$existe = $cedulasModel->getList(" documento='$documento' ","");
					if(count($existe)==0){
						$cedulasModel->insert($data);
					}else{
						if($data['nombres']!=""){
							$cedulasModel->editField($documento,"nombres",$data['nombres']);
						}
						if($data['fecha_ingreso']!=""){
							$cedulasModel->editField($documento,"fecha_ingreso",$data['fecha_ingreso']);
						}
						if($data['fecha_nacimiento']!=""){
							$cedulasModel->editField($documento,"fecha_nacimiento",$data['fecha_nacimiento']);
						}
						if($data['fecha_documento']!=""){
							$cedulasModel->editField($documento,"fecha_documento",$data['fecha_documento']);
						}
						if($data['genero']!=""){
							$cedulasModel->editField($documento,"genero",$data['genero']);
						}
						if($data['tipo_documento']!=""){
							$cedulasModel->editField($documento,"tipo_documento",$data['tipo_documento']);
						}
						if($data['barrio']!=""){
							$cedulasModel->editField($documento,"barrio",$data['barrio']);
						}
						if($data['ciudad_documento']!=""){
							$cedulasModel->editField($documento,"ciudad_documento",$data['ciudad_documento']);
						}
						if($data['estado_civil']!=""){
							$cedulasModel->editField($documento,"estado_civil",$data['estado_civil']);
						}
						if($data['empresa']!=""){
							$cedulasModel->editField($documento,"empresa",$data['empresa']);
						}
						if($data['direccion_oficina']!=""){
							$cedulasModel->editField($documento,"direccion_oficina",$data['direccion_oficina']);
						}
						if($data['telefono_oficina']!=""){
							$cedulasModel->editField($documento,"telefono_oficina",$data['telefono_oficina']);
						}
						if($data['fecha_afiliacion']!=""){
							$cedulasModel->editField($documento,"fecha_afiliacion",$data['fecha_afiliacion']);
						}
						if($data['cuenta_numero']!=""){
							$cedulasModel->editField($documento,"cuenta_numero",$data['cuenta_numero']);
						}
						if($data['cuenta_tipo']!=""){
							$cedulasModel->editField($documento,"cuenta_tipo",$data['cuenta_tipo']);
						}
						if($data['entidad_bancaria']!=""){
							$cedulasModel->editField($documento,"entidad_bancaria",$data['entidad_bancaria']);
						}
					}
				}

			}
		}

		//header("Location:/administracion/importarterceros/");
	}

	/**
     * Recibe un identificador  y elimina un importar asociados  y redirecciona al listado de importar asociados.
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
					if (isset($content->archivo_terceros) && $content->archivo_terceros != '') {
						$uploadDocument->delete($content->archivo_terceros);
					}
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR IMPORTAR ASOCIADOS';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Importarasociados.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['archivo'] = '' ;
		$data['archivo2'] = "";
		$data['archivo3'] = '' ;
		$data['archivo_inactivos'] = '' ;
		$data['archivo_terceros'] = '' ;
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
            if ($filters->archivo2 != '') {
                $filtros = $filtros." AND archivo2 LIKE '%".$filters->archivo2."%'";
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
					$parramsfilter['archivo2'] =  $this->_getSanitizedParam("archivo2");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}