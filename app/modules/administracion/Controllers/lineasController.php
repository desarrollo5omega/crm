<?php
/**
* Controlador de Lineas que permite la  creacion, edicion  y eliminacion de los l&iacute;neas de cr&eacute;dito del Sistema
*/
class Administracion_lineasController extends Administracion_mainController
{
	public $botonpanel = 5;
	/**
	 * $mainModel  instancia del modelo de  base de datos l&iacute;neas de cr&eacute;dito
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
	protected $_csrf_section = "administracion_lineas";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador lineas .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Lineas();
		$this->namefilter = "parametersfilterlineas";
		$this->route = "/administracion/lineas";
		$this->namepages ="pages_lineas";
		$this->namepageactual ="page_actual_lineas";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  l&iacute;neas de cr&eacute;dito con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de l&iacute;neas de cr&eacute;dito";
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
     * Genera la Informacion necesaria para editar o crear un  l&iacute;nea  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_lineas_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar l&iacute;nea";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear l&iacute;nea";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear l&iacute;nea";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}

		$garantiasModel = new Administracion_Model_DbTable_Garantias();
		$this->_view->garantias = $garantiasModel->getList(""," garantia_nombre ASC ");

		$garantialineaModel = new Administracion_Model_DbTable_Garantialinea();
		$array_garantias = array();
		$array_obligatorios = array();
		$codigo = $content->codigo;
		$garantialinea = $garantialineaModel->getList(" gl_linea_id='$codigo' ","");
		foreach ($garantialinea as $key => $value) {
			$array_garantias[$value->gl_garantia_id] = 1;
			$array_obligatorios[$value->gl_garantia_id] = $value->gl_obligatoria;
		}
		$this->_view->array_garantias = $array_garantias;
		$this->_view->array_obligatorios = $array_obligatorios;

	}

	/**
     * Inserta la informacion de un l&iacute;nea  y redirecciona al listado de l&iacute;neas de cr&eacute;dito.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$data = $this->getData();
			$id = $this->mainModel->insert($data);

			$data['id'] = $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR L&IACUTE;NEA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);

			//insertar garantiaslineas
			$array_gl = $data['array_gl'];
			$garantialineaModel = new Administracion_Model_DbTable_Garantialinea();
			$garantialineaModel->vaciar($data['codigo']);
			foreach ($array_gl as $key => $value) {
				$gl_linea_id = $data['gl_linea_id'] = $data['codigo'];
				$gl_garantia_id = $data['gl_garantia_id'] = $value->id;
				$gl_obligatoria = $data['gl_obligatoria'] = $value->obligatoria;
				$garantialineaModel->insert($data);
			}

		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un l&iacute;nea  y redirecciona al listado de l&iacute;neas de cr&eacute;dito.
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
			$data['log_tipo'] = 'EDITAR L&IACUTE;NEA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);

			//insertar garantiaslineas
			$array_gl = $data['array_gl'];
			$garantialineaModel = new Administracion_Model_DbTable_Garantialinea();
			$garantialineaModel->vaciar($data['codigo']);
			foreach ($array_gl as $key => $value) {
				$gl_linea_id = $data['gl_linea_id'] = $data['codigo'];
				$gl_garantia_id = $data['gl_garantia_id'] = $value['id'];
				$gl_obligatoria = $data['gl_obligatoria'] = $value['obligatoria'];
				$garantialineaModel->insert($data);
			}

		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un l&iacute;nea  y redirecciona al listado de l&iacute;neas de cr&eacute;dito.
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
					$data['log_tipo'] = 'BORRAR L&IACUTE;NEA';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Lineas.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['codigo'] = $this->_getSanitizedParam("codigo");
		$data['nombre'] = $this->_getSanitizedParam("nombre");
		$data['detalle'] = $this->_getSanitizedParam("detalle");
		$data['tasa_cobrada'] = '0';
		if($this->_getSanitizedParam("tasa_real") == '' ) {
			$data['tasa_real'] = '0';
		} else {
			$data['tasa_real'] = $this->_getSanitizedParam("tasa_real");
		}
		if($this->_getSanitizedParam("efectivo_anual") == '' ) {
			$data['efectivo_anual'] = '0';
		} else {
			$data['efectivo_anual'] = $this->_getSanitizedParam("efectivo_anual");
		}
		if($this->_getSanitizedParam("max_meses") == '' ) {
			$data['max_meses'] = '1';
		} else {
			$data['max_meses'] = $this->_getSanitizedParam("max_meses");
		}
		if($this->_getSanitizedParam("min_meses") == '' ) {
			$data['min_meses'] = '1';
		} else {
			$data['min_meses'] = $this->_getSanitizedParam("min_meses");
		}
		if($this->_getSanitizedParam("maxMonto") == '' ) {
			$data['maxMonto'] = '0';
		} else {
			$data['maxMonto'] = $this->_getSanitizedParam("maxMonto");
		}
		$data['descripcionGeneral'] = $this->_getSanitizedParamHtml("descripcionGeneral");
		$data['requisitos'] = $this->_getSanitizedParamHtml("requisitos");
		if($this->_getSanitizedParam("activo") == '' ) {
			$data['activo'] = '0';
		} else {
			$data['activo'] = $this->_getSanitizedParam("activo");
		}
		if($this->_getSanitizedParam("archivo1") == '' ) {
			$data['archivo1'] = '0';
		} else {
			$data['archivo1'] = $this->_getSanitizedParam("archivo1");
		}
		if($this->_getSanitizedParam("archivo2") == '' ) {
			$data['archivo2'] = '0';
		} else {
			$data['archivo2'] = $this->_getSanitizedParam("archivo2");
		}
		if($this->_getSanitizedParam("archivo3") == '' ) {
			$data['archivo3'] = '0';
		} else {
			$data['archivo3'] = $this->_getSanitizedParam("archivo3");
		}
		if($this->_getSanitizedParam("archivo4") == '' ) {
			$data['archivo4'] = '0';
		} else {
			$data['archivo4'] = $this->_getSanitizedParam("archivo4");
		}
		if($this->_getSanitizedParam("archivo22") == '' ) {
			$data['archivo22'] = '0';
		} else {
			$data['archivo22'] = $this->_getSanitizedParam("archivo22");
		}
		if($this->_getSanitizedParam("archivo23") == '' ) {
			$data['archivo23'] = '0';
		} else {
			$data['archivo23'] = $this->_getSanitizedParam("archivo23");
		}
		if($this->_getSanitizedParam("archivo24") == '' ) {
			$data['archivo24'] = '0';
		} else {
			$data['archivo24'] = $this->_getSanitizedParam("archivo24");
		}
		if($this->_getSanitizedParam("certificado_tradicion") == '' ) {
			$data['certificado_tradicion'] = '0';
		} else {
			$data['certificado_tradicion'] = $this->_getSanitizedParam("certificado_tradicion");
		}
		if($this->_getSanitizedParam("estado_obligacion") == '' ) {
			$data['estado_obligacion'] = '0';
		} else {
			$data['estado_obligacion'] = $this->_getSanitizedParam("estado_obligacion");
		}
		if($this->_getSanitizedParam("estado_obligacion2") == '' ) {
			$data['estado_obligacion2'] = '0';
		} else {
			$data['estado_obligacion2'] = $this->_getSanitizedParam("estado_obligacion2");
		}
		if($this->_getSanitizedParam("estado_obligacion3") == '' ) {
			$data['estado_obligacion3'] = '0';
		} else {
			$data['estado_obligacion3'] = $this->_getSanitizedParam("estado_obligacion3");
		}
		if($this->_getSanitizedParam("factura_proforma") == '' ) {
			$data['factura_proforma'] = '0';
		} else {
			$data['factura_proforma'] = $this->_getSanitizedParam("factura_proforma");
		}
		if($this->_getSanitizedParam("recibo_matricula") == '' ) {
			$data['recibo_matricula'] = '0';
		} else {
			$data['recibo_matricula'] = $this->_getSanitizedParam("recibo_matricula");
		}
		if($this->_getSanitizedParam("orden_medica") == '' ) {
			$data['orden_medica'] = '0';
		} else {
			$data['orden_medica'] = $this->_getSanitizedParam("orden_medica");
		}

		if($this->_getSanitizedParam("certificacion") == '' ) {
			$data['certificacion'] = '0';
		} else {
			$data['certificacion'] = $this->_getSanitizedParam("certificacion");
		}

		if($this->_getSanitizedParam("cotizacion") == '' ) {
			$data['cotizacion'] = '0';
		} else {
			$data['cotizacion'] = $this->_getSanitizedParam("cotizacion");
		}

		if($this->_getSanitizedParam("peritaje_vehiculo") == '' ) {
			$data['peritaje_vehiculo'] = '0';
		} else {
			$data['peritaje_vehiculo'] = $this->_getSanitizedParam("peritaje_vehiculo");
		}

		if($this->_getSanitizedParam("evidencia_calamidad") == '' ) {
			$data['evidencia_calamidad'] = '0';
		} else {
			$data['evidencia_calamidad'] = $this->_getSanitizedParam("evidencia_calamidad");
		}
		if($this->_getSanitizedParam("impuesto_vehiculo") == '' ) {
			$data['impuesto_vehiculo'] = '0';
		} else {
			$data['impuesto_vehiculo'] = $this->_getSanitizedParam("impuesto_vehiculo");
		}
		if($this->_getSanitizedParam("soat") == '' ) {
			$data['soat'] = '0';
		} else {
			$data['soat'] = $this->_getSanitizedParam("soat");
		}


		$array_gl = array();
		for($i=0;$i<=50;$i++){
			$valor = $this->_getSanitizedParam("garantia".$i);
			$valor2 = $this->_getSanitizedParam("obligatoria".$i);
			if($valor>0){
				$array_gl[] = array("id" => $valor, "obligatoria" => $valor2);
			}
		}
		$data['array_gl'] = $array_gl;
		$data['array_gl2'] = $array_gl2;

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
            if ($filters->codigo != '') {
                $filtros = $filtros." AND codigo LIKE '%".$filters->codigo."%'";
            }
            if ($filters->nombre != '') {
                $filtros = $filtros." AND nombre LIKE '%".$filters->nombre."%'";
            }
            if ($filters->activo != '') {
                $filtros = $filtros." AND activo LIKE '%".$filters->activo."%'";
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
					$parramsfilter['codigo'] =  $this->_getSanitizedParam("codigo");
					$parramsfilter['nombre'] =  $this->_getSanitizedParam("nombre");
					$parramsfilter['activo'] =  $this->_getSanitizedParam("activo");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }


	public function cargaAction()
	{
		$id = 1;
		$content = $this->mainModel->getById($id);
		$archivo = $content->archivo;
		$archivo = "lineas.xlsx";
		$this->getLayout()->setTitle("Importar lineas");

		//leer archivo
    	ini_set('memory_limit', '-1');
    	ini_set('max_execution_time', 300);
    	$inputFileName = FILE_PATH.'/'.$archivo;
   		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		$infoexel = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$lineasModel = new Administracion_Model_DbTable_Lineas();
		$i=0;

		foreach ($infoexel as $fila) {
			$i++;
			if($i>1){

				$codigo = $data['codigo'] = $fila[A];
				$nombre = $data['nombre'] = $fila[B];
				$max_meses = $data['max_meses'] = $fila[S];
				$efectivo_anual = $data['efectivo_anual'] = $fila[AO];
				$activo = $data['activo'] = 1;

				$tasa_cobrada = $data['tasa_cobrada'] = 0;
				$tasa_real = $data['tasa_real'] = 0;
				$maxMonto = $data['maxMonto'] = 0;
				$archivo1 = $data['archivo1'] = 1;
				$archivo2 = $data['archivo2'] = 1;
				$archivo3 = $data['archivo3'] = 1;
				$archivo4 = $data['archivo4'] = 0;
				$archivo22 = $data['archivo22'] = 0;
				$archivo23 = $data['archivo23'] = 0;
				$archivo24 = $data['archivo24'] = 0;
				$certificado_tradicion = $data['certificado_tradicion'] = 0;
				$estado_obligacion = $data['estado_obligacion'] = 0;
				$estado_obligacion2 = $data['estado_obligacion2'] = 0;
				$estado_obligacion3 = $data['estado_obligacion3'] = 0;
				$factura_proforma = $data['factura_proforma'] = 0;
				$recibo_matricula = $data['recibo_matricula'] = 0;


				if($data['codigo']!=""){
					$existe = $lineasModel->getList(" codigo='$codigo' ","");
					if(count($existe)==0){
						$lineasModel->insert($data);
					}else{
						$id = $existe[0]->id;
						if($max_meses!=""){
							$lineasModel->editField($id,"max_meses",$max_meses);
						}
						if($efectivo_anual!=""){
							$lineasModel->editField($id,"efectivo_anual",$efectivo_anual);
						}
					}
				}

			}
		}

		//header("Location:/administracion/importarcupos/");
	}

}