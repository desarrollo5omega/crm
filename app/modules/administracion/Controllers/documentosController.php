<?php
/**
* Controlador de Documentos que permite la  creacion, edicion  y eliminacion de los documentos del Sistema
*/
class Administracion_documentosController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos documentos
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
	protected $_csrf_section = "administracion_documentos";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador documentos .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Documentos();
		$this->namefilter = "parametersfilterdocumentos";
		$this->route = "/administracion/documentos";
		$this->namepages ="pages_documentos";
		$this->namepageactual ="page_actual_documentos";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  documentos con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de documentos";
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
     * Genera la Informacion necesaria para editar o crear un  documentos  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_documentos_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar documentos";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear documentos";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear documentos";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un documentos  y redirecciona al listado de documentos.
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
			$data['log_tipo'] = 'CREAR DOCUMENTOS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un documentos  y redirecciona al listado de documentos.
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
			$data['log_tipo'] = 'EDITAR DOCUMENTOS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un documentos  y redirecciona al listado de documentos.
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
					$data['log_tipo'] = 'BORRAR DOCUMENTOS';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Documentos.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		if($this->_getSanitizedParam("solicitud") == '' ) {
			$data['solicitud'] = '0';
		} else {
			$data['solicitud'] = $this->_getSanitizedParam("solicitud");
		}
		$data['cedula'] = $this->_getSanitizedParam("cedula");
		$data['desprendible_pago'] = $this->_getSanitizedParam("desprendible_pago");
		$data['desprendible_pago2'] = $this->_getSanitizedParam("desprendible_pago2");
		$data['desprendible_pago3'] = $this->_getSanitizedParam("desprendible_pago3");
		$data['desprendible_pago4'] = $this->_getSanitizedParam("desprendible_pago4");
		$data['certificado_laboral'] = $this->_getSanitizedParam("certificado_laboral");
		$data['otros_ingresos'] = $this->_getSanitizedParam("otros_ingresos");
		$data['certificado_tradicion'] = $this->_getSanitizedParam("certificado_tradicion");
		$data['estado_obligacion'] = $this->_getSanitizedParam("estado_obligacion");
		$data['estado_obligacion2'] = $this->_getSanitizedParam("estado_obligacion2");
		$data['estado_obligacion3'] = $this->_getSanitizedParam("estado_obligacion3");
		$data['factura_proforma'] = $this->_getSanitizedParam("factura_proforma");
		$data['recibo_matricula'] = $this->_getSanitizedParam("recibo_matricula");
		$data['contrato_vivienda'] = $this->_getSanitizedParam("contrato_vivienda");
		$data['orden_medica'] = $this->_getSanitizedParam("orden_medica");
		$data['declaracion_renta'] = $this->_getSanitizedParam("declaracion_renta");
		$data['certificacion'] = $this->_getSanitizedParam("certificacion");
		$data['cotizacion'] = $this->_getSanitizedParam("cotizacion");
		$data['evidencia_calamidad'] = $this->_getSanitizedParam("evidencia_calamidad");
		$data['declaracion_renta'] = $this->_getSanitizedParam("declaracion_renta");
		$data['impuesto_vehiculo'] = $this->_getSanitizedParam("impuesto_vehiculo");
		$data['soat'] = $this->_getSanitizedParam("soat");
		if($this->_getSanitizedParam("tipo") == '' ) {
			$data['tipo'] = '0';
		} else {
			$data['tipo'] = $this->_getSanitizedParam("tipo");
		}
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
            if ($filters->solicitud != '') {
                $filtros = $filtros." AND solicitud LIKE '%".$filters->solicitud."%'";
            }
            if ($filters->cedula != '') {
                $filtros = $filtros." AND cedula LIKE '%".$filters->cedula."%'";
            }
            if ($filters->desprendible_pago != '') {
                $filtros = $filtros." AND desprendible_pago LIKE '%".$filters->desprendible_pago."%'";
            }
            if ($filters->desprendible_pago2 != '') {
                $filtros = $filtros." AND desprendible_pago2 LIKE '%".$filters->desprendible_pago2."%'";
            }
            if ($filters->desprendible_pago3 != '') {
                $filtros = $filtros." AND desprendible_pago3 LIKE '%".$filters->desprendible_pago3."%'";
            }
            if ($filters->desprendible_pago4 != '') {
                $filtros = $filtros." AND desprendible_pago4 LIKE '%".$filters->desprendible_pago4."%'";
            }
            if ($filters->certificado_laboral != '') {
                $filtros = $filtros." AND certificado_laboral LIKE '%".$filters->certificado_laboral."%'";
            }
            if ($filters->otros_ingresos != '') {
                $filtros = $filtros." AND otros_ingresos LIKE '%".$filters->otros_ingresos."%'";
            }
            if ($filters->certificado_tradicion != '') {
                $filtros = $filtros." AND certificado_tradicion LIKE '%".$filters->certificado_tradicion."%'";
            }
            if ($filters->estado_obligacion != '') {
                $filtros = $filtros." AND estado_obligacion LIKE '%".$filters->estado_obligacion."%'";
            }
            if ($filters->estado_obligacion2 != '') {
                $filtros = $filtros." AND estado_obligacion2 LIKE '%".$filters->estado_obligacion2."%'";
            }
            if ($filters->estado_obligacion3 != '') {
                $filtros = $filtros." AND estado_obligacion3 LIKE '%".$filters->estado_obligacion3."%'";
            }
            if ($filters->factura_proforma != '') {
                $filtros = $filtros." AND factura_proforma LIKE '%".$filters->factura_proforma."%'";
            }
            if ($filters->recibo_matricula != '') {
                $filtros = $filtros." AND recibo_matricula LIKE '%".$filters->recibo_matricula."%'";
            }
            if ($filters->contrato_vivienda != '') {
                $filtros = $filtros." AND contrato_vivienda LIKE '%".$filters->contrato_vivienda."%'";
            }
            if ($filters->declaracion_renta != '') {
                $filtros = $filtros." AND declaracion_renta LIKE '%".$filters->declaracion_renta."%'";
            }
            if ($filters->tipo != '') {
                $filtros = $filtros." AND tipo LIKE '%".$filters->tipo."%'";
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
					$parramsfilter['solicitud'] =  $this->_getSanitizedParam("solicitud");
					$parramsfilter['cedula'] =  $this->_getSanitizedParam("cedula");
					$parramsfilter['desprendible_pago'] =  $this->_getSanitizedParam("desprendible_pago");
					$parramsfilter['desprendible_pago2'] =  $this->_getSanitizedParam("desprendible_pago2");
					$parramsfilter['desprendible_pago3'] =  $this->_getSanitizedParam("desprendible_pago3");
					$parramsfilter['desprendible_pago4'] =  $this->_getSanitizedParam("desprendible_pago4");
					$parramsfilter['certificado_laboral'] =  $this->_getSanitizedParam("certificado_laboral");
					$parramsfilter['otros_ingresos'] =  $this->_getSanitizedParam("otros_ingresos");
					$parramsfilter['certificado_tradicion'] =  $this->_getSanitizedParam("certificado_tradicion");
					$parramsfilter['estado_obligacion'] =  $this->_getSanitizedParam("estado_obligacion");
					$parramsfilter['estado_obligacion2'] =  $this->_getSanitizedParam("estado_obligacion2");
					$parramsfilter['estado_obligacion3'] =  $this->_getSanitizedParam("estado_obligacion3");
					$parramsfilter['factura_proforma'] =  $this->_getSanitizedParam("factura_proforma");
					$parramsfilter['recibo_matricula'] =  $this->_getSanitizedParam("recibo_matricula");
					$parramsfilter['contrato_vivienda'] =  $this->_getSanitizedParam("contrato_vivienda");
					$parramsfilter['declaracion_renta'] =  $this->_getSanitizedParam("declaracion_renta");
					$parramsfilter['tipo'] =  $this->_getSanitizedParam("tipo");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}