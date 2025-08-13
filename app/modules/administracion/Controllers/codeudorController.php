<?php
/**
* Controlador de Codeudor que permite la  creacion, edicion  y eliminacion de los codeudor del Sistema
*/
class Administracion_codeudorController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos codeudor
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
	protected $_csrf_section = "administracion_codeudor";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador codeudor .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Codeudor();
		$this->namefilter = "parametersfiltercodeudor";
		$this->route = "/administracion/codeudor";
		$this->namepages ="pages_codeudor";
		$this->namepageactual ="page_actual_codeudor";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  codeudor con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de codeudor";
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
     * Genera la Informacion necesaria para editar o crear un  coudedor  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_codeudor_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar coudedor";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear coudedor";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear coudedor";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un coudedor  y redirecciona al listado de codeudor.
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
			$data['log_tipo'] = 'CREAR COUDEDOR';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un coudedor  y redirecciona al listado de codeudor.
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
			$data['log_tipo'] = 'EDITAR COUDEDOR';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un coudedor  y redirecciona al listado de codeudor.
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
					$data['log_tipo'] = 'BORRAR COUDEDOR';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Codeudor.
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
		$data['nombres'] = $this->_getSanitizedParam("nombres");
		$data['nombres2'] = $this->_getSanitizedParam("nombres2");
		$data['apellido1'] = $this->_getSanitizedParam("apellido1");
		$data['apellido2'] = $this->_getSanitizedParam("apellido2");
		$data['cedula'] = $this->_getSanitizedParam("cedula");
		$data['tipo_documento'] = $this->_getSanitizedParam("tipo_documento");
		$data['sexo'] = $this->_getSanitizedParam("sexo");
		$data['ciudad_documento'] = $this->_getSanitizedParam("ciudad_documento");
		$data['empresa'] = $this->_getSanitizedParam("empresa");
		$data['dependencia'] = $this->_getSanitizedParam("dependencia");
		$data['direccion_oficina'] = $this->_getSanitizedParam("direccion_oficina");
		$data['ciudad_oficina'] = $this->_getSanitizedParam("ciudad_oficina");
		$data['telefono_oficina'] = $this->_getSanitizedParam("telefono_oficina");
		$data['cargo'] = $this->_getSanitizedParam("cargo");
		$data['ciudad'] = $this->_getSanitizedParam("ciudad");
		$data['telefono'] = $this->_getSanitizedParam("telefono");
		$data['correo_empresarial'] = $this->_getSanitizedParam("correo_empresarial");
		$data['situacion_laboral'] = $this->_getSanitizedParam("situacion_laboral");
		$data['cual'] = $this->_getSanitizedParam("cual");
		$data['estado_civil'] = $this->_getSanitizedParam("estado_civil");
		$data['conyuge_nombre'] = $this->_getSanitizedParam("conyuge_nombre");
		$data['conyuge_telefono'] = $this->_getSanitizedParam("conyuge_telefono");
		$data['conyuge_celular'] = $this->_getSanitizedParam("conyuge_celular");
		$data['declara_renta'] = $this->_getSanitizedParam("declara_renta");
		$data['persona_publica'] = $this->_getSanitizedParam("persona_publica");
		$data['cuenta_numero'] = $this->_getSanitizedParam("cuenta_numero");
		$data['cuenta_tipo'] = $this->_getSanitizedParam("cuenta_tipo");
		$data['entidad_bancaria'] = $this->_getSanitizedParam("entidad_bancaria");
		$data['celular'] = $this->_getSanitizedParam("celular");
		$data['direccion_residencia'] = $this->_getSanitizedParam("direccion_residencia");
		$data['barrio'] = $this->_getSanitizedParam("barrio");
		$data['ciudad_residencia'] = $this->_getSanitizedParam("ciudad_residencia");
		if($this->_getSanitizedParam("salario") == '' ) {
			$data['salario'] = '0';
		} else {
			$data['salario'] = $this->_getSanitizedParam("salario");
		}
		$data['forma_pago'] = $this->_getSanitizedParam("forma_pago");
		if($this->_getSanitizedParam("tiempo_anio") == '' ) {
			$data['tiempo_anio'] = '0';
		} else {
			$data['tiempo_anio'] = $this->_getSanitizedParam("tiempo_anio");
		}
		if($this->_getSanitizedParam("tiempo_meses") == '' ) {
			$data['tiempo_meses'] = '0';
		} else {
			$data['tiempo_meses'] = $this->_getSanitizedParam("tiempo_meses");
		}
		$data['correo'] = $this->_getSanitizedParam("correo");
		$data['asociado'] = $this->_getSanitizedParam("asociado");
		$data['fecha_nacimiento'] = $this->_getSanitizedParam("fecha_nacimiento");
		$data['fecha_documento'] = $this->_getSanitizedParam("fecha_documento");
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
            if ($filters->nombres != '') {
                $filtros = $filtros." AND nombres LIKE '%".$filters->nombres."%'";
            }
            if ($filters->nombres2 != '') {
                $filtros = $filtros." AND nombres2 LIKE '%".$filters->nombres2."%'";
            }
            if ($filters->apellido1 != '') {
                $filtros = $filtros." AND apellido1 LIKE '%".$filters->apellido1."%'";
            }
            if ($filters->apellido2 != '') {
                $filtros = $filtros." AND apellido2 LIKE '%".$filters->apellido2."%'";
            }
            if ($filters->cedula != '') {
                $filtros = $filtros." AND cedula LIKE '%".$filters->cedula."%'";
            }
            if ($filters->tipo_documento != '') {
                $filtros = $filtros." AND tipo_documento LIKE '%".$filters->tipo_documento."%'";
            }
            if ($filters->sexo != '') {
                $filtros = $filtros." AND sexo LIKE '%".$filters->sexo."%'";
            }
            if ($filters->ciudad_documento != '') {
                $filtros = $filtros." AND ciudad_documento LIKE '%".$filters->ciudad_documento."%'";
            }
            if ($filters->empresa != '') {
                $filtros = $filtros." AND empresa LIKE '%".$filters->empresa."%'";
            }
            if ($filters->dependencia != '') {
                $filtros = $filtros." AND dependencia LIKE '%".$filters->dependencia."%'";
            }
            if ($filters->direccion_oficina != '') {
                $filtros = $filtros." AND direccion_oficina LIKE '%".$filters->direccion_oficina."%'";
            }
            if ($filters->ciudad_oficina != '') {
                $filtros = $filtros." AND ciudad_oficina LIKE '%".$filters->ciudad_oficina."%'";
            }
            if ($filters->telefono_oficina != '') {
                $filtros = $filtros." AND telefono_oficina LIKE '%".$filters->telefono_oficina."%'";
            }
            if ($filters->cargo != '') {
                $filtros = $filtros." AND cargo LIKE '%".$filters->cargo."%'";
            }
            if ($filters->ciudad != '') {
                $filtros = $filtros." AND ciudad LIKE '%".$filters->ciudad."%'";
            }
            if ($filters->telefono != '') {
                $filtros = $filtros." AND telefono LIKE '%".$filters->telefono."%'";
            }
            if ($filters->correo_empresarial != '') {
                $filtros = $filtros." AND correo_empresarial LIKE '%".$filters->correo_empresarial."%'";
            }
            if ($filters->situacion_laboral != '') {
                $filtros = $filtros." AND situacion_laboral LIKE '%".$filters->situacion_laboral."%'";
            }
            if ($filters->cual != '') {
                $filtros = $filtros." AND cual LIKE '%".$filters->cual."%'";
            }
            if ($filters->estado_civil != '') {
                $filtros = $filtros." AND estado_civil LIKE '%".$filters->estado_civil."%'";
            }
            if ($filters->conyuge_nombre != '') {
                $filtros = $filtros." AND conyuge_nombre LIKE '%".$filters->conyuge_nombre."%'";
            }
            if ($filters->conyuge_telefono != '') {
                $filtros = $filtros." AND conyuge_telefono LIKE '%".$filters->conyuge_telefono."%'";
            }
            if ($filters->conyuge_celular != '') {
                $filtros = $filtros." AND conyuge_celular LIKE '%".$filters->conyuge_celular."%'";
            }
            if ($filters->declara_renta != '') {
                $filtros = $filtros." AND declara_renta LIKE '%".$filters->declara_renta."%'";
            }
            if ($filters->persona_publica != '') {
                $filtros = $filtros." AND persona_publica LIKE '%".$filters->persona_publica."%'";
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
            if ($filters->celular != '') {
                $filtros = $filtros." AND celular LIKE '%".$filters->celular."%'";
            }
            if ($filters->direccion_residencia != '') {
                $filtros = $filtros." AND direccion_residencia LIKE '%".$filters->direccion_residencia."%'";
            }
            if ($filters->barrio != '') {
                $filtros = $filtros." AND barrio LIKE '%".$filters->barrio."%'";
            }
            if ($filters->ciudad_residencia != '') {
                $filtros = $filtros." AND ciudad_residencia LIKE '%".$filters->ciudad_residencia."%'";
            }
            if ($filters->salario != '') {
                $filtros = $filtros." AND salario LIKE '%".$filters->salario."%'";
            }
            if ($filters->forma_pago != '') {
                $filtros = $filtros." AND forma_pago LIKE '%".$filters->forma_pago."%'";
            }
            if ($filters->tiempo_anio != '') {
                $filtros = $filtros." AND tiempo_anio LIKE '%".$filters->tiempo_anio."%'";
            }
            if ($filters->tiempo_meses != '') {
                $filtros = $filtros." AND tiempo_meses LIKE '%".$filters->tiempo_meses."%'";
            }
            if ($filters->correo != '') {
                $filtros = $filtros." AND correo LIKE '%".$filters->correo."%'";
            }
            if ($filters->asociado != '') {
                $filtros = $filtros." AND asociado LIKE '%".$filters->asociado."%'";
            }
            if ($filters->fecha_nacimiento != '') {
                $filtros = $filtros." AND fecha_nacimiento LIKE '%".$filters->fecha_nacimiento."%'";
            }
            if ($filters->fecha_documento != '') {
                $filtros = $filtros." AND fecha_documento LIKE '%".$filters->fecha_documento."%'";
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
					$parramsfilter['nombres'] =  $this->_getSanitizedParam("nombres");
					$parramsfilter['nombres2'] =  $this->_getSanitizedParam("nombres2");
					$parramsfilter['apellido1'] =  $this->_getSanitizedParam("apellido1");
					$parramsfilter['apellido2'] =  $this->_getSanitizedParam("apellido2");
					$parramsfilter['cedula'] =  $this->_getSanitizedParam("cedula");
					$parramsfilter['tipo_documento'] =  $this->_getSanitizedParam("tipo_documento");
					$parramsfilter['sexo'] =  $this->_getSanitizedParam("sexo");
					$parramsfilter['ciudad_documento'] =  $this->_getSanitizedParam("ciudad_documento");
					$parramsfilter['empresa'] =  $this->_getSanitizedParam("empresa");
					$parramsfilter['dependencia'] =  $this->_getSanitizedParam("dependencia");
					$parramsfilter['direccion_oficina'] =  $this->_getSanitizedParam("direccion_oficina");
					$parramsfilter['ciudad_oficina'] =  $this->_getSanitizedParam("ciudad_oficina");
					$parramsfilter['telefono_oficina'] =  $this->_getSanitizedParam("telefono_oficina");
					$parramsfilter['cargo'] =  $this->_getSanitizedParam("cargo");
					$parramsfilter['ciudad'] =  $this->_getSanitizedParam("ciudad");
					$parramsfilter['telefono'] =  $this->_getSanitizedParam("telefono");
					$parramsfilter['correo_empresarial'] =  $this->_getSanitizedParam("correo_empresarial");
					$parramsfilter['situacion_laboral'] =  $this->_getSanitizedParam("situacion_laboral");
					$parramsfilter['cual'] =  $this->_getSanitizedParam("cual");
					$parramsfilter['estado_civil'] =  $this->_getSanitizedParam("estado_civil");
					$parramsfilter['conyuge_nombre'] =  $this->_getSanitizedParam("conyuge_nombre");
					$parramsfilter['conyuge_telefono'] =  $this->_getSanitizedParam("conyuge_telefono");
					$parramsfilter['conyuge_celular'] =  $this->_getSanitizedParam("conyuge_celular");
					$parramsfilter['declara_renta'] =  $this->_getSanitizedParam("declara_renta");
					$parramsfilter['persona_publica'] =  $this->_getSanitizedParam("persona_publica");
					$parramsfilter['cuenta_numero'] =  $this->_getSanitizedParam("cuenta_numero");
					$parramsfilter['cuenta_tipo'] =  $this->_getSanitizedParam("cuenta_tipo");
					$parramsfilter['entidad_bancaria'] =  $this->_getSanitizedParam("entidad_bancaria");
					$parramsfilter['celular'] =  $this->_getSanitizedParam("celular");
					$parramsfilter['direccion_residencia'] =  $this->_getSanitizedParam("direccion_residencia");
					$parramsfilter['barrio'] =  $this->_getSanitizedParam("barrio");
					$parramsfilter['ciudad_residencia'] =  $this->_getSanitizedParam("ciudad_residencia");
					$parramsfilter['salario'] =  $this->_getSanitizedParam("salario");
					$parramsfilter['forma_pago'] =  $this->_getSanitizedParam("forma_pago");
					$parramsfilter['tiempo_anio'] =  $this->_getSanitizedParam("tiempo_anio");
					$parramsfilter['tiempo_meses'] =  $this->_getSanitizedParam("tiempo_meses");
					$parramsfilter['correo'] =  $this->_getSanitizedParam("correo");
					$parramsfilter['asociado'] =  $this->_getSanitizedParam("asociado");
					$parramsfilter['fecha_nacimiento'] =  $this->_getSanitizedParam("fecha_nacimiento");
					$parramsfilter['fecha_documento'] =  $this->_getSanitizedParam("fecha_documento");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}