<?php
/**
* Controlador de Asegurabilidad que permite la  creacion, edicion  y eliminacion de los asegurabilidad del Sistema
*/
class Administracion_asegurabilidadController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos asegurabilidad
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
	protected $_csrf_section = "administracion_asegurabilidad";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador asegurabilidad .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Asegurabilidad();
		$this->namefilter = "parametersfilterasegurabilidad";
		$this->route = "/administracion/asegurabilidad";
		$this->namepages ="pages_asegurabilidad";
		$this->namepageactual ="page_actual_asegurabilidad";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  asegurabilidad con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de asegurabilidad";
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
     * Genera la Informacion necesaria para editar o crear un  asegurabilidad  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_asegurabilidad_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar asegurabilidad";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear asegurabilidad";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear asegurabilidad";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un asegurabilidad  y redirecciona al listado de asegurabilidad.
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
			$data['log_tipo'] = 'CREAR ASEGURABILIDAD';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un asegurabilidad  y redirecciona al listado de asegurabilidad.
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
			$data['log_tipo'] = 'EDITAR ASEGURABILIDAD';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un asegurabilidad  y redirecciona al listado de asegurabilidad.
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
					$data['log_tipo'] = 'BORRAR ASEGURABILIDAD';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Asegurabilidad.
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
		if($this->_getSanitizedParam("paso") == '' ) {
			$data['paso'] = '0';
		} else {
			$data['paso'] = $this->_getSanitizedParam("paso");
		}
		$data['fecha'] = $this->_getSanitizedParam("fecha");
		$data['tipo_documento'] = $this->_getSanitizedParam("tipo_documento");
		$data['documento'] = $this->_getSanitizedParam("documento");
		$data['nombres'] = $this->_getSanitizedParam("nombres");
		$data['nombres2'] = $this->_getSanitizedParam("nombres2");
		$data['apellido1'] = $this->_getSanitizedParam("apellido1");
		$data['apellido2'] = $this->_getSanitizedParam("apellido2");
		if($this->_getSanitizedParam("fn_dia") == '' ) {
			$data['fn_dia'] = '0';
		} else {
			$data['fn_dia'] = $this->_getSanitizedParam("fn_dia");
		}
		if($this->_getSanitizedParam("fn_mes") == '' ) {
			$data['fn_mes'] = '0';
		} else {
			$data['fn_mes'] = $this->_getSanitizedParam("fn_mes");
		}
		if($this->_getSanitizedParam("fn_anio") == '' ) {
			$data['fn_anio'] = '0';
		} else {
			$data['fn_anio'] = $this->_getSanitizedParam("fn_anio");
		}
		$data['telefono_oficina'] = $this->_getSanitizedParam("telefono_oficina");
		$data['correo_personal'] = $this->_getSanitizedParam("correo_personal");
		$data['direccion_residencia'] = $this->_getSanitizedParam("direccion_residencia");
		$data['ciudad_residencia'] = $this->_getSanitizedParam("ciudad_residencia");
		$data['sexo'] = $this->_getSanitizedParam("sexo");
		$data['celular'] = $this->_getSanitizedParam("celular");
		$data['ocupacion'] = $this->_getSanitizedParam("ocupacion");
		$data['estado_civil'] = $this->_getSanitizedParam("estado_civil");
		$data['peso'] = $this->_getSanitizedParam("peso");
		$data['estatura'] = $this->_getSanitizedParam("estatura");
		$data['prima'] = $this->_getSanitizedParam("prima");
		$data['prima_valor'] = $this->_getSanitizedParam("prima_valor");
		$data['otra_cual'] = $this->_getSanitizedParam("otra_cual");
		$data['otra_cual2'] = $this->_getSanitizedParam("otra_cual2");
		$data['tiene'] = $this->_getSanitizedParam("tiene");
		$data['drogas'] = $this->_getSanitizedParam("drogas");
		$data['alcoholismo'] = $this->_getSanitizedParam("alcoholismo");
		$data['drogadiccion'] = $this->_getSanitizedParam("drogadiccion");
		$data['hospitalizado'] = $this->_getSanitizedParam("hospitalizado");
		$data['antecedentes'] = $this->_getSanitizedParam("antecedentes");
		$data['observaciones'] = $this->_getSanitizedParam("observaciones");
		$data['cobertura'] = $this->_getSanitizedParam("cobertura");
		if($this->_getSanitizedParam("consecutivo") == '' ) {
			$data['consecutivo'] = '0';
		} else {
			$data['consecutivo'] = $this->_getSanitizedParam("consecutivo");
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
            if ($filters->paso != '') {
                $filtros = $filtros." AND paso LIKE '%".$filters->paso."%'";
            }
            if ($filters->fecha != '') {
                $filtros = $filtros." AND fecha LIKE '%".$filters->fecha."%'";
            }
            if ($filters->tipo_documento != '') {
                $filtros = $filtros." AND tipo_documento LIKE '%".$filters->tipo_documento."%'";
            }
            if ($filters->documento != '') {
                $filtros = $filtros." AND documento LIKE '%".$filters->documento."%'";
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
            if ($filters->fn_dia != '') {
                $filtros = $filtros." AND fn_dia LIKE '%".$filters->fn_dia."%'";
            }
            if ($filters->fn_mes != '') {
                $filtros = $filtros." AND fn_mes LIKE '%".$filters->fn_mes."%'";
            }
            if ($filters->fn_anio != '') {
                $filtros = $filtros." AND fn_anio LIKE '%".$filters->fn_anio."%'";
            }
            if ($filters->telefono_oficina != '') {
                $filtros = $filtros." AND telefono_oficina LIKE '%".$filters->telefono_oficina."%'";
            }
            if ($filters->correo_personal != '') {
                $filtros = $filtros." AND correo_personal LIKE '%".$filters->correo_personal."%'";
            }
            if ($filters->direccion_residencia != '') {
                $filtros = $filtros." AND direccion_residencia LIKE '%".$filters->direccion_residencia."%'";
            }
            if ($filters->ciudad_residencia != '') {
                $filtros = $filtros." AND ciudad_residencia LIKE '%".$filters->ciudad_residencia."%'";
            }
            if ($filters->sexo != '') {
                $filtros = $filtros." AND sexo LIKE '%".$filters->sexo."%'";
            }
            if ($filters->celular != '') {
                $filtros = $filtros." AND celular LIKE '%".$filters->celular."%'";
            }
            if ($filters->ocupacion != '') {
                $filtros = $filtros." AND ocupacion LIKE '%".$filters->ocupacion."%'";
            }
            if ($filters->estado_civil != '') {
                $filtros = $filtros." AND estado_civil LIKE '%".$filters->estado_civil."%'";
            }
            if ($filters->peso != '') {
                $filtros = $filtros." AND peso LIKE '%".$filters->peso."%'";
            }
            if ($filters->estatura != '') {
                $filtros = $filtros." AND estatura LIKE '%".$filters->estatura."%'";
            }
            if ($filters->prima != '') {
                $filtros = $filtros." AND prima LIKE '%".$filters->prima."%'";
            }
            if ($filters->prima_valor != '') {
                $filtros = $filtros." AND prima_valor LIKE '%".$filters->prima_valor."%'";
            }
            if ($filters->otra_cual != '') {
                $filtros = $filtros." AND otra_cual LIKE '%".$filters->otra_cual."%'";
            }
            if ($filters->otra_cual2 != '') {
                $filtros = $filtros." AND otra_cual2 LIKE '%".$filters->otra_cual2."%'";
            }
            if ($filters->tiene != '') {
                $filtros = $filtros." AND tiene LIKE '%".$filters->tiene."%'";
            }
            if ($filters->drogas != '') {
                $filtros = $filtros." AND drogas LIKE '%".$filters->drogas."%'";
            }
            if ($filters->alcoholismo != '') {
                $filtros = $filtros." AND alcoholismo LIKE '%".$filters->alcoholismo."%'";
            }
            if ($filters->drogadiccion != '') {
                $filtros = $filtros." AND drogadiccion LIKE '%".$filters->drogadiccion."%'";
            }
            if ($filters->hospitalizado != '') {
                $filtros = $filtros." AND hospitalizado LIKE '%".$filters->hospitalizado."%'";
            }
            if ($filters->antecedentes != '') {
                $filtros = $filtros." AND antecedentes LIKE '%".$filters->antecedentes."%'";
            }
            if ($filters->observaciones != '') {
                $filtros = $filtros." AND observaciones LIKE '%".$filters->observaciones."%'";
            }
            if ($filters->cobertura != '') {
                $filtros = $filtros." AND cobertura LIKE '%".$filters->cobertura."%'";
            }
            if ($filters->consecutivo != '') {
                $filtros = $filtros." AND consecutivo LIKE '%".$filters->consecutivo."%'";
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
					$parramsfilter['paso'] =  $this->_getSanitizedParam("paso");
					$parramsfilter['fecha'] =  $this->_getSanitizedParam("fecha");
					$parramsfilter['tipo_documento'] =  $this->_getSanitizedParam("tipo_documento");
					$parramsfilter['documento'] =  $this->_getSanitizedParam("documento");
					$parramsfilter['nombres'] =  $this->_getSanitizedParam("nombres");
					$parramsfilter['nombres2'] =  $this->_getSanitizedParam("nombres2");
					$parramsfilter['apellido1'] =  $this->_getSanitizedParam("apellido1");
					$parramsfilter['apellido2'] =  $this->_getSanitizedParam("apellido2");
					$parramsfilter['fn_dia'] =  $this->_getSanitizedParam("fn_dia");
					$parramsfilter['fn_mes'] =  $this->_getSanitizedParam("fn_mes");
					$parramsfilter['fn_anio'] =  $this->_getSanitizedParam("fn_anio");
					$parramsfilter['telefono_oficina'] =  $this->_getSanitizedParam("telefono_oficina");
					$parramsfilter['correo_personal'] =  $this->_getSanitizedParam("correo_personal");
					$parramsfilter['direccion_residencia'] =  $this->_getSanitizedParam("direccion_residencia");
					$parramsfilter['ciudad_residencia'] =  $this->_getSanitizedParam("ciudad_residencia");
					$parramsfilter['sexo'] =  $this->_getSanitizedParam("sexo");
					$parramsfilter['celular'] =  $this->_getSanitizedParam("celular");
					$parramsfilter['ocupacion'] =  $this->_getSanitizedParam("ocupacion");
					$parramsfilter['estado_civil'] =  $this->_getSanitizedParam("estado_civil");
					$parramsfilter['peso'] =  $this->_getSanitizedParam("peso");
					$parramsfilter['estatura'] =  $this->_getSanitizedParam("estatura");
					$parramsfilter['prima'] =  $this->_getSanitizedParam("prima");
					$parramsfilter['prima_valor'] =  $this->_getSanitizedParam("prima_valor");
					$parramsfilter['otra_cual'] =  $this->_getSanitizedParam("otra_cual");
					$parramsfilter['otra_cual2'] =  $this->_getSanitizedParam("otra_cual2");
					$parramsfilter['tiene'] =  $this->_getSanitizedParam("tiene");
					$parramsfilter['drogas'] =  $this->_getSanitizedParam("drogas");
					$parramsfilter['alcoholismo'] =  $this->_getSanitizedParam("alcoholismo");
					$parramsfilter['drogadiccion'] =  $this->_getSanitizedParam("drogadiccion");
					$parramsfilter['hospitalizado'] =  $this->_getSanitizedParam("hospitalizado");
					$parramsfilter['antecedentes'] =  $this->_getSanitizedParam("antecedentes");
					$parramsfilter['observaciones'] =  $this->_getSanitizedParam("observaciones");
					$parramsfilter['cobertura'] =  $this->_getSanitizedParam("cobertura");
					$parramsfilter['consecutivo'] =  $this->_getSanitizedParam("consecutivo");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}