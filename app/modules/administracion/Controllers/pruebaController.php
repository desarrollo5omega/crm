<?php
/**
* Controlador de Prueba que permite la  creacion, edicion  y eliminacion de los prueba del Sistema
*/
class Administracion_pruebaController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos prueba
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
	protected $_csrf_section = "administracion_prueba";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador prueba .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Prueba();
		$this->namefilter = "parametersfilterprueba";
		$this->route = "/administracion/prueba";
		$this->namepages ="pages_prueba";
		$this->namepageactual ="page_actual_prueba";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  prueba con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de prueba";
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
     * Genera la Informacion necesaria para editar o crear un  prueba  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_prueba_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar prueba";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear prueba";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear prueba";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un prueba  y redirecciona al listado de prueba.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR PRUEBA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un prueba  y redirecciona al listado de prueba.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR PRUEBA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un prueba  y redirecciona al listado de prueba.
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
					$data['log_tipo'] = 'BORRAR PRUEBA';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Prueba.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['documento'] = $this->_getSanitizedParam("documento");
		$data['tipo_documento'] = $this->_getSanitizedParam("tipo_documento");
		$data['fecha_documento'] = $this->_getSanitizedParam("fecha_documento");
		$data['nombres'] = $this->_getSanitizedParam("nombres");
		$data['apellidos'] = $this->_getSanitizedParam("apellidos");
		$data['ciudad'] = $this->_getSanitizedParam("ciudad");
		$data['departamento'] = $this->_getSanitizedParam("departamento");
		$data['pais'] = $this->_getSanitizedParam("pais");
		$data['ciudad_documento'] = $this->_getSanitizedParam("ciudad_documento");
		$data['departamento_documento'] = $this->_getSanitizedParam("departamento_documento");
		$data['pais_documento'] = $this->_getSanitizedParam("pais_documento");
		$data['fecha_nacimiento'] = $this->_getSanitizedParam("fecha_nacimiento");
		$data['ciudad_nacimiento'] = $this->_getSanitizedParam("ciudad_nacimiento");
		$data['direccion'] = $this->_getSanitizedParam("direccion");
		$data['email'] = $this->_getSanitizedParam("email");
		$data['email2'] = $this->_getSanitizedParam("email2");
		$data['telefono'] = $this->_getSanitizedParam("telefono");
		$data['telefono2'] = $this->_getSanitizedParam("telefono2");
		$data['celular'] = $this->_getSanitizedParam("celular");
		$data['fecha_ingreso'] = $this->_getSanitizedParam("fecha_ingreso");
		$data['genero'] = $this->_getSanitizedParam("genero");
		$data['empresa'] = $this->_getSanitizedParam("empresa");
		$data['empresa_cual'] = $this->_getSanitizedParam("empresa_cual");
		$data['barrio'] = $this->_getSanitizedParam("barrio");
		$data['estado_civil'] = $this->_getSanitizedParam("estado_civil");
		$data['direccion_oficina'] = $this->_getSanitizedParam("direccion_oficina");
		$data['telefono_oficina'] = $this->_getSanitizedParam("telefono_oficina");
		$data['telefono_oficina2'] = $this->_getSanitizedParam("telefono_oficina2");
		$data['telefono_oficina_ext'] = $this->_getSanitizedParam("telefono_oficina_ext");
		$data['fecha_afiliacion'] = $this->_getSanitizedParam("fecha_afiliacion");
		$data['cuenta_numero'] = $this->_getSanitizedParam("cuenta_numero");
		$data['cuenta_tipo'] = $this->_getSanitizedParam("cuenta_tipo");
		$data['entidad_bancaria'] = $this->_getSanitizedParam("entidad_bancaria");
		$data['nivel_educativo'] = $this->_getSanitizedParam("nivel_educativo");
		$data['titulo'] = $this->_getSanitizedParam("titulo");
		$data['intereses'] = $this->_getSanitizedParam("intereses");
		$data['codigo_ciuu'] = $this->_getSanitizedParam("codigo_ciuu");
		$data['cargo'] = $this->_getSanitizedParam("cargo");
		$data['salario'] = $this->_getSanitizedParam("salario");
		$data['sede'] = $this->_getSanitizedParam("sede");
		$data['ciudad_oficina'] = $this->_getSanitizedParam("ciudad_oficina");
		$data['valor_cuota_periodica'] = $this->_getSanitizedParam("valor_cuota_periodica");
		$data['valor_ahorro_voluntario'] = $this->_getSanitizedParam("valor_ahorro_voluntario");
		$data['valor_ahorro_incentivo'] = $this->_getSanitizedParam("valor_ahorro_incentivo");
		$data['recursos_publicos'] = $this->_getSanitizedParam("recursos_publicos");
		$data['poder_publico'] = $this->_getSanitizedParam("poder_publico");
		$data['reconocimiento'] = $this->_getSanitizedParam("reconocimiento");
		$data['familiares'] = $this->_getSanitizedParam("familiares");
		$data['especifique'] = $this->_getSanitizedParam("especifique");
		$data['ingresos_mensuales'] = $this->_getSanitizedParam("ingresos_mensuales");
		$data['egresos_mensuales'] = $this->_getSanitizedParam("egresos_mensuales");
		$data['activos'] = $this->_getSanitizedParam("activos");
		$data['pasivos'] = $this->_getSanitizedParam("pasivos");
		$data['patrimonio'] = $this->_getSanitizedParam("patrimonio");
		$data['otros_ingresos'] = $this->_getSanitizedParam("otros_ingresos");
		$data['concepto_otros_ingresos'] = $this->_getSanitizedParam("concepto_otros_ingresos");
		$data['transacciones_moneda_extranjera'] = $this->_getSanitizedParam("transacciones_moneda_extranjera");
		$data['operaciones_internacionales'] = $this->_getSanitizedParam("operaciones_internacionales");
		$data['operaciones_cual'] = $this->_getSanitizedParam("operaciones_cual");
		$data['producto_tipo'] = $this->_getSanitizedParam("producto_tipo");
		$data['producto_numero'] = $this->_getSanitizedParam("producto_numero");
		$data['producto_entidad'] = $this->_getSanitizedParam("producto_entidad");
		$data['producto_monto'] = $this->_getSanitizedParam("producto_monto");
		$data['producto_ciudad'] = $this->_getSanitizedParam("producto_ciudad");
		$data['producto_pais'] = $this->_getSanitizedParam("producto_pais");
		$data['producto_moneda'] = $this->_getSanitizedParam("producto_moneda");
		$data['situacion_laboral'] = $this->_getSanitizedParam("situacion_laboral");
		$data['id_deceval'] = $this->_getSanitizedParam("id_deceval");
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
            if ($filters->documento != '') {
                $filtros = $filtros." AND documento LIKE '%".$filters->documento."%'";
            }
            if ($filters->tipo_documento != '') {
                $filtros = $filtros." AND tipo_documento LIKE '%".$filters->tipo_documento."%'";
            }
            if ($filters->fecha_documento != '') {
                $filtros = $filtros." AND fecha_documento LIKE '%".$filters->fecha_documento."%'";
            }
            if ($filters->nombres != '') {
                $filtros = $filtros." AND nombres LIKE '%".$filters->nombres."%'";
            }
            if ($filters->apellidos != '') {
                $filtros = $filtros." AND apellidos LIKE '%".$filters->apellidos."%'";
            }
            if ($filters->ciudad != '') {
                $filtros = $filtros." AND ciudad LIKE '%".$filters->ciudad."%'";
            }
            if ($filters->departamento != '') {
                $filtros = $filtros." AND departamento LIKE '%".$filters->departamento."%'";
            }
            if ($filters->pais != '') {
                $filtros = $filtros." AND pais LIKE '%".$filters->pais."%'";
            }
            if ($filters->ciudad_documento != '') {
                $filtros = $filtros." AND ciudad_documento LIKE '%".$filters->ciudad_documento."%'";
            }
            if ($filters->departamento_documento != '') {
                $filtros = $filtros." AND departamento_documento LIKE '%".$filters->departamento_documento."%'";
            }
            if ($filters->pais_documento != '') {
                $filtros = $filtros." AND pais_documento LIKE '%".$filters->pais_documento."%'";
            }
            if ($filters->fecha_nacimiento != '') {
                $filtros = $filtros." AND fecha_nacimiento LIKE '%".$filters->fecha_nacimiento."%'";
            }
            if ($filters->ciudad_nacimiento != '') {
                $filtros = $filtros." AND ciudad_nacimiento LIKE '%".$filters->ciudad_nacimiento."%'";
            }
            if ($filters->direccion != '') {
                $filtros = $filtros." AND direccion LIKE '%".$filters->direccion."%'";
            }
            if ($filters->email != '') {
                $filtros = $filtros." AND email LIKE '%".$filters->email."%'";
            }
            if ($filters->email2 != '') {
                $filtros = $filtros." AND email2 LIKE '%".$filters->email2."%'";
            }
            if ($filters->telefono != '') {
                $filtros = $filtros." AND telefono LIKE '%".$filters->telefono."%'";
            }
            if ($filters->telefono2 != '') {
                $filtros = $filtros." AND telefono2 LIKE '%".$filters->telefono2."%'";
            }
            if ($filters->celular != '') {
                $filtros = $filtros." AND celular LIKE '%".$filters->celular."%'";
            }
            if ($filters->fecha_ingreso != '') {
                $filtros = $filtros." AND fecha_ingreso LIKE '%".$filters->fecha_ingreso."%'";
            }
            if ($filters->genero != '') {
                $filtros = $filtros." AND genero LIKE '%".$filters->genero."%'";
            }
            if ($filters->empresa != '') {
                $filtros = $filtros." AND empresa LIKE '%".$filters->empresa."%'";
            }
            if ($filters->empresa_cual != '') {
                $filtros = $filtros." AND empresa_cual LIKE '%".$filters->empresa_cual."%'";
            }
            if ($filters->barrio != '') {
                $filtros = $filtros." AND barrio LIKE '%".$filters->barrio."%'";
            }
            if ($filters->estado_civil != '') {
                $filtros = $filtros." AND estado_civil LIKE '%".$filters->estado_civil."%'";
            }
            if ($filters->direccion_oficina != '') {
                $filtros = $filtros." AND direccion_oficina LIKE '%".$filters->direccion_oficina."%'";
            }
            if ($filters->telefono_oficina != '') {
                $filtros = $filtros." AND telefono_oficina LIKE '%".$filters->telefono_oficina."%'";
            }
            if ($filters->telefono_oficina2 != '') {
                $filtros = $filtros." AND telefono_oficina2 LIKE '%".$filters->telefono_oficina2."%'";
            }
            if ($filters->telefono_oficina_ext != '') {
                $filtros = $filtros." AND telefono_oficina_ext LIKE '%".$filters->telefono_oficina_ext."%'";
            }
            if ($filters->fecha_afiliacion != '') {
                $filtros = $filtros." AND fecha_afiliacion LIKE '%".$filters->fecha_afiliacion."%'";
            }
            if ($filters->cuenta_numero != '') {
                $filtros = $filtros." AND cuenta_numero LIKE '%".$filters->cuenta_numero."%'";
            }
            if ($filters->cuenta_tipo != '') {
                $filtros = $filtros." AND cuenta_tipo LIKE '%".$filters->cuenta_tipo."%'";
            }
            if ($filters->entidad_bancaria != '') {
                $filtros = $filtros." AND entidad_bancaria LIKE '%".$filters->entidad_bancaria."%'";
            }
            if ($filters->nivel_educativo != '') {
                $filtros = $filtros." AND nivel_educativo LIKE '%".$filters->nivel_educativo."%'";
            }
            if ($filters->titulo != '') {
                $filtros = $filtros." AND titulo LIKE '%".$filters->titulo."%'";
            }
            if ($filters->intereses != '') {
                $filtros = $filtros." AND intereses LIKE '%".$filters->intereses."%'";
            }
            if ($filters->codigo_ciuu != '') {
                $filtros = $filtros." AND codigo_ciuu LIKE '%".$filters->codigo_ciuu."%'";
            }
            if ($filters->cargo != '') {
                $filtros = $filtros." AND cargo LIKE '%".$filters->cargo."%'";
            }
            if ($filters->salario != '') {
                $filtros = $filtros." AND salario LIKE '%".$filters->salario."%'";
            }
            if ($filters->sede != '') {
                $filtros = $filtros." AND sede LIKE '%".$filters->sede."%'";
            }
            if ($filters->ciudad_oficina != '') {
                $filtros = $filtros." AND ciudad_oficina LIKE '%".$filters->ciudad_oficina."%'";
            }
            if ($filters->valor_cuota_periodica != '') {
                $filtros = $filtros." AND valor_cuota_periodica LIKE '%".$filters->valor_cuota_periodica."%'";
            }
            if ($filters->valor_ahorro_voluntario != '') {
                $filtros = $filtros." AND valor_ahorro_voluntario LIKE '%".$filters->valor_ahorro_voluntario."%'";
            }
            if ($filters->valor_ahorro_incentivo != '') {
                $filtros = $filtros." AND valor_ahorro_incentivo LIKE '%".$filters->valor_ahorro_incentivo."%'";
            }
            if ($filters->recursos_publicos != '') {
                $filtros = $filtros." AND recursos_publicos LIKE '%".$filters->recursos_publicos."%'";
            }
            if ($filters->poder_publico != '') {
                $filtros = $filtros." AND poder_publico LIKE '%".$filters->poder_publico."%'";
            }
            if ($filters->reconocimiento != '') {
                $filtros = $filtros." AND reconocimiento LIKE '%".$filters->reconocimiento."%'";
            }
            if ($filters->familiares != '') {
                $filtros = $filtros." AND familiares LIKE '%".$filters->familiares."%'";
            }
            if ($filters->especifique != '') {
                $filtros = $filtros." AND especifique LIKE '%".$filters->especifique."%'";
            }
            if ($filters->ingresos_mensuales != '') {
                $filtros = $filtros." AND ingresos_mensuales LIKE '%".$filters->ingresos_mensuales."%'";
            }
            if ($filters->egresos_mensuales != '') {
                $filtros = $filtros." AND egresos_mensuales LIKE '%".$filters->egresos_mensuales."%'";
            }
            if ($filters->activos != '') {
                $filtros = $filtros." AND activos LIKE '%".$filters->activos."%'";
            }
            if ($filters->pasivos != '') {
                $filtros = $filtros." AND pasivos LIKE '%".$filters->pasivos."%'";
            }
            if ($filters->patrimonio != '') {
                $filtros = $filtros." AND patrimonio LIKE '%".$filters->patrimonio."%'";
            }
            if ($filters->otros_ingresos != '') {
                $filtros = $filtros." AND otros_ingresos LIKE '%".$filters->otros_ingresos."%'";
            }
            if ($filters->concepto_otros_ingresos != '') {
                $filtros = $filtros." AND concepto_otros_ingresos LIKE '%".$filters->concepto_otros_ingresos."%'";
            }
            if ($filters->transacciones_moneda_extranjera != '') {
                $filtros = $filtros." AND transacciones_moneda_extranjera LIKE '%".$filters->transacciones_moneda_extranjera."%'";
            }
            if ($filters->operaciones_internacionales != '') {
                $filtros = $filtros." AND operaciones_internacionales LIKE '%".$filters->operaciones_internacionales."%'";
            }
            if ($filters->operaciones_cual != '') {
                $filtros = $filtros." AND operaciones_cual LIKE '%".$filters->operaciones_cual."%'";
            }
            if ($filters->producto_tipo != '') {
                $filtros = $filtros." AND producto_tipo LIKE '%".$filters->producto_tipo."%'";
            }
            if ($filters->producto_numero != '') {
                $filtros = $filtros." AND producto_numero LIKE '%".$filters->producto_numero."%'";
            }
            if ($filters->producto_entidad != '') {
                $filtros = $filtros." AND producto_entidad LIKE '%".$filters->producto_entidad."%'";
            }
            if ($filters->producto_monto != '') {
                $filtros = $filtros." AND producto_monto LIKE '%".$filters->producto_monto."%'";
            }
            if ($filters->producto_ciudad != '') {
                $filtros = $filtros." AND producto_ciudad LIKE '%".$filters->producto_ciudad."%'";
            }
            if ($filters->producto_pais != '') {
                $filtros = $filtros." AND producto_pais LIKE '%".$filters->producto_pais."%'";
            }
            if ($filters->producto_moneda != '') {
                $filtros = $filtros." AND producto_moneda LIKE '%".$filters->producto_moneda."%'";
            }
            if ($filters->situacion_laboral != '') {
                $filtros = $filtros." AND situacion_laboral LIKE '%".$filters->situacion_laboral."%'";
            }
            if ($filters->id_deceval != '') {
                $filtros = $filtros." AND id_deceval LIKE '%".$filters->id_deceval."%'";
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
					$parramsfilter['documento'] =  $this->_getSanitizedParam("documento");
					$parramsfilter['tipo_documento'] =  $this->_getSanitizedParam("tipo_documento");
					$parramsfilter['fecha_documento'] =  $this->_getSanitizedParam("fecha_documento");
					$parramsfilter['nombres'] =  $this->_getSanitizedParam("nombres");
					$parramsfilter['apellidos'] =  $this->_getSanitizedParam("apellidos");
					$parramsfilter['ciudad'] =  $this->_getSanitizedParam("ciudad");
					$parramsfilter['departamento'] =  $this->_getSanitizedParam("departamento");
					$parramsfilter['pais'] =  $this->_getSanitizedParam("pais");
					$parramsfilter['ciudad_documento'] =  $this->_getSanitizedParam("ciudad_documento");
					$parramsfilter['departamento_documento'] =  $this->_getSanitizedParam("departamento_documento");
					$parramsfilter['pais_documento'] =  $this->_getSanitizedParam("pais_documento");
					$parramsfilter['fecha_nacimiento'] =  $this->_getSanitizedParam("fecha_nacimiento");
					$parramsfilter['ciudad_nacimiento'] =  $this->_getSanitizedParam("ciudad_nacimiento");
					$parramsfilter['direccion'] =  $this->_getSanitizedParam("direccion");
					$parramsfilter['email'] =  $this->_getSanitizedParam("email");
					$parramsfilter['email2'] =  $this->_getSanitizedParam("email2");
					$parramsfilter['telefono'] =  $this->_getSanitizedParam("telefono");
					$parramsfilter['telefono2'] =  $this->_getSanitizedParam("telefono2");
					$parramsfilter['celular'] =  $this->_getSanitizedParam("celular");
					$parramsfilter['fecha_ingreso'] =  $this->_getSanitizedParam("fecha_ingreso");
					$parramsfilter['genero'] =  $this->_getSanitizedParam("genero");
					$parramsfilter['empresa'] =  $this->_getSanitizedParam("empresa");
					$parramsfilter['empresa_cual'] =  $this->_getSanitizedParam("empresa_cual");
					$parramsfilter['barrio'] =  $this->_getSanitizedParam("barrio");
					$parramsfilter['estado_civil'] =  $this->_getSanitizedParam("estado_civil");
					$parramsfilter['direccion_oficina'] =  $this->_getSanitizedParam("direccion_oficina");
					$parramsfilter['telefono_oficina'] =  $this->_getSanitizedParam("telefono_oficina");
					$parramsfilter['telefono_oficina2'] =  $this->_getSanitizedParam("telefono_oficina2");
					$parramsfilter['telefono_oficina_ext'] =  $this->_getSanitizedParam("telefono_oficina_ext");
					$parramsfilter['fecha_afiliacion'] =  $this->_getSanitizedParam("fecha_afiliacion");
					$parramsfilter['cuenta_numero'] =  $this->_getSanitizedParam("cuenta_numero");
					$parramsfilter['cuenta_tipo'] =  $this->_getSanitizedParam("cuenta_tipo");
					$parramsfilter['entidad_bancaria'] =  $this->_getSanitizedParam("entidad_bancaria");
					$parramsfilter['nivel_educativo'] =  $this->_getSanitizedParam("nivel_educativo");
					$parramsfilter['titulo'] =  $this->_getSanitizedParam("titulo");
					$parramsfilter['intereses'] =  $this->_getSanitizedParam("intereses");
					$parramsfilter['codigo_ciuu'] =  $this->_getSanitizedParam("codigo_ciuu");
					$parramsfilter['cargo'] =  $this->_getSanitizedParam("cargo");
					$parramsfilter['salario'] =  $this->_getSanitizedParam("salario");
					$parramsfilter['sede'] =  $this->_getSanitizedParam("sede");
					$parramsfilter['ciudad_oficina'] =  $this->_getSanitizedParam("ciudad_oficina");
					$parramsfilter['valor_cuota_periodica'] =  $this->_getSanitizedParam("valor_cuota_periodica");
					$parramsfilter['valor_ahorro_voluntario'] =  $this->_getSanitizedParam("valor_ahorro_voluntario");
					$parramsfilter['valor_ahorro_incentivo'] =  $this->_getSanitizedParam("valor_ahorro_incentivo");
					$parramsfilter['recursos_publicos'] =  $this->_getSanitizedParam("recursos_publicos");
					$parramsfilter['poder_publico'] =  $this->_getSanitizedParam("poder_publico");
					$parramsfilter['reconocimiento'] =  $this->_getSanitizedParam("reconocimiento");
					$parramsfilter['familiares'] =  $this->_getSanitizedParam("familiares");
					$parramsfilter['especifique'] =  $this->_getSanitizedParam("especifique");
					$parramsfilter['ingresos_mensuales'] =  $this->_getSanitizedParam("ingresos_mensuales");
					$parramsfilter['egresos_mensuales'] =  $this->_getSanitizedParam("egresos_mensuales");
					$parramsfilter['activos'] =  $this->_getSanitizedParam("activos");
					$parramsfilter['pasivos'] =  $this->_getSanitizedParam("pasivos");
					$parramsfilter['patrimonio'] =  $this->_getSanitizedParam("patrimonio");
					$parramsfilter['otros_ingresos'] =  $this->_getSanitizedParam("otros_ingresos");
					$parramsfilter['concepto_otros_ingresos'] =  $this->_getSanitizedParam("concepto_otros_ingresos");
					$parramsfilter['transacciones_moneda_extranjera'] =  $this->_getSanitizedParam("transacciones_moneda_extranjera");
					$parramsfilter['operaciones_internacionales'] =  $this->_getSanitizedParam("operaciones_internacionales");
					$parramsfilter['operaciones_cual'] =  $this->_getSanitizedParam("operaciones_cual");
					$parramsfilter['producto_tipo'] =  $this->_getSanitizedParam("producto_tipo");
					$parramsfilter['producto_numero'] =  $this->_getSanitizedParam("producto_numero");
					$parramsfilter['producto_entidad'] =  $this->_getSanitizedParam("producto_entidad");
					$parramsfilter['producto_monto'] =  $this->_getSanitizedParam("producto_monto");
					$parramsfilter['producto_ciudad'] =  $this->_getSanitizedParam("producto_ciudad");
					$parramsfilter['producto_pais'] =  $this->_getSanitizedParam("producto_pais");
					$parramsfilter['producto_moneda'] =  $this->_getSanitizedParam("producto_moneda");
					$parramsfilter['situacion_laboral'] =  $this->_getSanitizedParam("situacion_laboral");
					$parramsfilter['id_deceval'] =  $this->_getSanitizedParam("id_deceval");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}