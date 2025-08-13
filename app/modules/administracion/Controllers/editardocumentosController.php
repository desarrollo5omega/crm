<?php

/**

* Controlador de Editardocumentos que permite la  creacion, edicion  y eliminacion de los editar documentos del Sistema

*/

class Administracion_editardocumentosController extends Administracion_mainController

{

	/**

	 * $mainModel  instancia del modelo de  base de datos editar documentos

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

	protected $_csrf_section = "administracion_editardocumentos";



	/**

	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador

	 * @var string

	 */

	protected $namepages;







	/**

     * Inicializa las variables principales del controlador editardocumentos .

     *

     * @return void.

     */

	public function init()

	{

		$this->mainModel = new Administracion_Model_DbTable_Editardocumentos();

		$this->namefilter = "parametersfiltereditardocumentos";

		$this->route = "/administracion/editardocumentos";

		$this->namepages ="pages_editardocumentos";

		$this->namepageactual ="page_actual_editardocumentos";

		$this->_view->route = $this->route;

		if(Session::getInstance()->get($this->namepages)){

			$this->pages = Session::getInstance()->get($this->namepages);

		} else {

			$this->pages = 20;

		}

		parent::init();

	}





	/**

     * Recibe la informacion y  muestra un listado de  editar documentos con sus respectivos filtros.

     *

     * @return void.

     */

	public function indexAction()

	{

		$title = "Administración de editar documentos";

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

		$this->_view->id = $this->_getSanitizedParam("id");

		$this->_view->tipo = $this->_getSanitizedParam("tipo");

	}



	/**

     * Genera la Informacion necesaria para editar o crear un  editar documentos  y muestra su formulario

     *

     * @return void.

     */

	public function manageAction()

	{

		$this->_view->route = $this->route;

		$this->_csrf_section = "manage_editardocumentos_".date("YmdHis");

		$this->_csrf->generateCode($this->_csrf_section);

		$this->_view->csrf_section = $this->_csrf_section;

		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];

		$this->_view->id = $this->_getSanitizedParam("id");

		$this->_view->tipo = $this->_getSanitizedParam("tipo");

		$id = $this->_getSanitizedParam("id");

		if ($id > 0) {

			$content = $this->mainModel->getById($id);

			if($content->id){

				$this->_view->content = $content;

				$this->_view->routeform = $this->route."/update";

				$title = "Actualizar editar documentos";

				$this->getLayout()->setTitle($title);

				$this->_view->titlesection = $title;

			}else{

				$this->_view->routeform = $this->route."/insert";

				$title = "Crear editar documentos";

				$this->getLayout()->setTitle($title);

				$this->_view->titlesection = $title;

			}

		} else {

			$this->_view->routeform = $this->route."/insert";

			$title = "Crear editar documentos";

			$this->getLayout()->setTitle($title);

			$this->_view->titlesection = $title;

		}

	}



	/**

     * Inserta la informacion de un editar documentos  y redirecciona al listado de editar documentos.

     *

     * @return void.

     */

	public function insertAction(){

		$this->setLayout('blanco');

		$csrf = $this->_getSanitizedParam("csrf");

		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {

			$data = $this->getData();

			$uploadImage =  new Core_Model_Upload_Image();

			if($_FILES['cedula']['name'] != ''){

				$data['cedula'] = $uploadImage->upload("cedula");

			}

			if($_FILES['desprendible_pago']['name'] != ''){

				$data['desprendible_pago'] = $uploadImage->upload("desprendible_pago");

			}

			if($_FILES['desprendible_pago2']['name'] != ''){

				$data['desprendible_pago2'] = $uploadImage->upload("desprendible_pago2");

			}

			if($_FILES['desprendible_pago3']['name'] != ''){

				$data['desprendible_pago3'] = $uploadImage->upload("desprendible_pago3");

			}

			if($_FILES['desprendible_pago4']['name'] != ''){

				$data['desprendible_pago4'] = $uploadImage->upload("desprendible_pago4");

			}

			if($_FILES['desprendible_pago5']['name'] != ''){

				$data['desprendible_pago5'] = $uploadImage->upload("desprendible_pago5");

			}

			if($_FILES['certificado_laboral']['name'] != ''){

				$data['certificado_laboral'] = $uploadImage->upload("certificado_laboral");

			}

			if($_FILES['otros_ingresos']['name'] != ''){

				$data['otros_ingresos'] = $uploadImage->upload("otros_ingresos");

			}

			if($_FILES['certificado_tradicion']['name'] != ''){

				$data['certificado_tradicion'] = $uploadImage->upload("certificado_tradicion");

			}

			if($_FILES['estado_obligacion']['name'] != ''){

				$data['estado_obligacion'] = $uploadImage->upload("estado_obligacion");

			}

			if($_FILES['estado_obligacion2']['name'] != ''){

				$data['estado_obligacion2'] = $uploadImage->upload("estado_obligacion2");

			}

			if($_FILES['estado_obligacion3']['name'] != ''){

				$data['estado_obligacion3'] = $uploadImage->upload("estado_obligacion3");

			}

			if($_FILES['factura_proforma']['name'] != ''){

				$data['factura_proforma'] = $uploadImage->upload("factura_proforma");

			}

			if($_FILES['recibo_matricula']['name'] != ''){

				$data['recibo_matricula'] = $uploadImage->upload("recibo_matricula");

			}

			if($_FILES['contrato_vivienda']['name'] != ''){

				$data['contrato_vivienda'] = $uploadImage->upload("contrato_vivienda");

			}

			if($_FILES['declaracion_renta']['name'] != ''){

				$data['declaracion_renta'] = $uploadImage->upload("declaracion_renta");

			}

			$id = $this->mainModel->insert($data);

			

			$data['id']= $id;

			$data['log_log'] = print_r($data,true);

			$data['log_tipo'] = 'CREAR EDITAR DOCUMENTOS';

			$logModel = new Administracion_Model_DbTable_Log();

			$logModel->insert($data);

		}

		$id = $this->_getSanitizedParam("solicitud");

		$tipo = $this->_getSanitizedParam("tipo");

		header('Location: '.$this->route.'?id='.$id.'&tipo='.$tipo.'');

	}



	/**

     * Recibe un identificador  y Actualiza la informacion de un editar documentos  y redirecciona al listado de editar documentos.

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
				$uploadImage =  new Core_Model_Upload_Image();
				if($_FILES['cedula']['name'] != ''){
					if($content->cedula){
						$uploadImage->delete($content->cedula);
					}
					$data['cedula'] = $uploadImage->upload("cedula");
				} else {
					$data['cedula'] = $content->cedula;
				}


				if($_FILES['desprendible_pago']['name'] != ''){
					if($content->desprendible_pago){
						$uploadImage->delete($content->desprendible_pago);
					}
					$data['desprendible_pago'] = $uploadImage->upload("desprendible_pago");
				} else {
					$data['desprendible_pago'] = $content->desprendible_pago;
				}



				if($_FILES['desprendible_pago2']['name'] != ''){
					if($content->desprendible_pago2){
						$uploadImage->delete($content->desprendible_pago2);
					}
					$data['desprendible_pago2'] = $uploadImage->upload("desprendible_pago2");
				} else {
					$data['desprendible_pago2'] = $content->desprendible_pago2;
				}

			

				if($_FILES['desprendible_pago3']['name'] != ''){
					if($content->desprendible_pago3){
						$uploadImage->delete($content->desprendible_pago3);
					}
					$data['desprendible_pago3'] = $uploadImage->upload("desprendible_pago3");
				} else {
					$data['desprendible_pago3'] = $content->desprendible_pago3;
				}

			

				if($_FILES['desprendible_pago4']['name'] != ''){
					if($content->desprendible_pago4){
						$uploadImage->delete($content->desprendible_pago4);
					}

					$data['desprendible_pago4'] = $uploadImage->upload("desprendible_pago4");
				} else {
					$data['desprendible_pago4'] = $content->desprendible_pago4;
				}

			

				if($_FILES['desprendible_pago5']['name'] != ''){
					if($content->desprendible_pago5){
						$uploadImage->delete($content->desprendible_pago5);
					}
					$data['desprendible_pago5'] = $uploadImage->upload("desprendible_pago5");
				} else {
					$data['desprendible_pago5'] = $content->desprendible_pago5;
				}

			

				if($_FILES['certificado_laboral']['name'] != ''){
					if($content->certificado_laboral){
						$uploadImage->delete($content->certificado_laboral);
					}
					$data['certificado_laboral'] = $uploadImage->upload("certificado_laboral");
				} else {
					$data['certificado_laboral'] = $content->certificado_laboral;
				}

			

				if($_FILES['otros_ingresos']['name'] != ''){
					if($content->otros_ingresos){
						$uploadImage->delete($content->otros_ingresos);
					}
					$data['otros_ingresos'] = $uploadImage->upload("otros_ingresos");
				} else {
					$data['otros_ingresos'] = $content->otros_ingresos;
				}

			

				if($_FILES['certificado_tradicion']['name'] != ''){
					if($content->certificado_tradicion){
						$uploadImage->delete($content->certificado_tradicion);
					}

					$data['certificado_tradicion'] = $uploadImage->upload("certificado_tradicion");

				} else {

					$data['certificado_tradicion'] = $content->certificado_tradicion;

				}

			

				if($_FILES['estado_obligacion']['name'] != ''){

					if($content->estado_obligacion){

						$uploadImage->delete($content->estado_obligacion);

					}

					$data['estado_obligacion'] = $uploadImage->upload("estado_obligacion");

				} else {

					$data['estado_obligacion'] = $content->estado_obligacion;

				}

			

				if($_FILES['estado_obligacion2']['name'] != ''){

					if($content->estado_obligacion2){

						$uploadImage->delete($content->estado_obligacion2);

					}

					$data['estado_obligacion2'] = $uploadImage->upload("estado_obligacion2");

				} else {

					$data['estado_obligacion2'] = $content->estado_obligacion2;

				}

			

				if($_FILES['estado_obligacion3']['name'] != ''){

					if($content->estado_obligacion3){

						$uploadImage->delete($content->estado_obligacion3);

					}

					$data['estado_obligacion3'] = $uploadImage->upload("estado_obligacion3");

				} else {

					$data['estado_obligacion3'] = $content->estado_obligacion3;

				}

			

				if($_FILES['factura_proforma']['name'] != ''){

					if($content->factura_proforma){

						$uploadImage->delete($content->factura_proforma);

					}

					$data['factura_proforma'] = $uploadImage->upload("factura_proforma");

				} else {

					$data['factura_proforma'] = $content->factura_proforma;

				}

			

				if($_FILES['recibo_matricula']['name'] != ''){

					if($content->recibo_matricula){

						$uploadImage->delete($content->recibo_matricula);

					}

					$data['recibo_matricula'] = $uploadImage->upload("recibo_matricula");

				} else {

					$data['recibo_matricula'] = $content->recibo_matricula;

				}

			

				if($_FILES['contrato_vivienda']['name'] != ''){

					if($content->contrato_vivienda){

						$uploadImage->delete($content->contrato_vivienda);

					}

					$data['contrato_vivienda'] = $uploadImage->upload("contrato_vivienda");

				} else {

					$data['contrato_vivienda'] = $content->contrato_vivienda;

				}

				if($_FILES['declaracion_renta']['name'] != ''){
					if($content->declaracion_renta){
						$uploadImage->delete($content->declaracion_renta);
					}

					$data['declaracion_renta'] = $uploadImage->upload("declaracion_renta");
				} else {
					$data['declaracion_renta'] = $content->declaracion_renta;
				}

				$this->mainModel->update($data,$id);

			}

			$data['id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR EDITAR DOCUMENTOS';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}

		$solicitud = $this->_getSanitizedParam("solicitud");
		$tipo = $this->_getSanitizedParam("tipo");

		//header('Location: '.$this->route.'?id='.$id.'&tipo='.$tipo.'');
		header('Location:/administracion/solicitudes/detalle/?id='.$solicitud.'&paso=6');

	}



	/**

     * Recibe un identificador  y elimina un editar documentos  y redirecciona al listado de editar documentos.

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

					$uploadImage =  new Core_Model_Upload_Image();

					if (isset($content->cedula) && $content->cedula != '') {

						$uploadImage->delete($content->cedula);

					}

					

					if (isset($content->desprendible_pago) && $content->desprendible_pago != '') {

						$uploadImage->delete($content->desprendible_pago);

					}

					

					if (isset($content->desprendible_pago2) && $content->desprendible_pago2 != '') {

						$uploadImage->delete($content->desprendible_pago2);

					}

					

					if (isset($content->desprendible_pago3) && $content->desprendible_pago3 != '') {

						$uploadImage->delete($content->desprendible_pago3);

					}

					

					if (isset($content->desprendible_pago4) && $content->desprendible_pago4 != '') {

						$uploadImage->delete($content->desprendible_pago4);

					}

					

					if (isset($content->desprendible_pago5) && $content->desprendible_pago5 != '') {

						$uploadImage->delete($content->desprendible_pago5);

					}

					

					if (isset($content->certificado_laboral) && $content->certificado_laboral != '') {

						$uploadImage->delete($content->certificado_laboral);

					}

					

					if (isset($content->otros_ingresos) && $content->otros_ingresos != '') {

						$uploadImage->delete($content->otros_ingresos);

					}

					

					if (isset($content->certificado_tradicion) && $content->certificado_tradicion != '') {

						$uploadImage->delete($content->certificado_tradicion);

					}

					

					if (isset($content->estado_obligacion) && $content->estado_obligacion != '') {

						$uploadImage->delete($content->estado_obligacion);

					}

					

					if (isset($content->estado_obligacion2) && $content->estado_obligacion2 != '') {

						$uploadImage->delete($content->estado_obligacion2);

					}

					

					if (isset($content->estado_obligacion3) && $content->estado_obligacion3 != '') {

						$uploadImage->delete($content->estado_obligacion3);

					}

					

					if (isset($content->factura_proforma) && $content->factura_proforma != '') {

						$uploadImage->delete($content->factura_proforma);

					}

					

					if (isset($content->recibo_matricula) && $content->recibo_matricula != '') {

						$uploadImage->delete($content->recibo_matricula);

					}

					

					if (isset($content->contrato_vivienda) && $content->contrato_vivienda != '') {

						$uploadImage->delete($content->contrato_vivienda);

					}

					

					if (isset($content->declaracion_renta) && $content->declaracion_renta != '') {

						$uploadImage->delete($content->declaracion_renta);

					}

					$this->mainModel->deleteRegister($id);$data = (array)$content;

					$data['log_log'] = print_r($data,true);

					$data['log_tipo'] = 'BORRAR EDITAR DOCUMENTOS';

					$logModel = new Administracion_Model_DbTable_Log();

					$logModel->insert($data); }

			}

		}

		$id = $this->_getSanitizedParam("id");

		$tipo = $this->_getSanitizedParam("tipo");

		header('Location: '.$this->route.'?id='.$id.'&tipo='.$tipo.'');

	}



	/**

     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Editardocumentos.

     *

     * @return array con toda la informacion recibida del formulario.

     */

	private function getData()

	{

		$data = array();

		$data['solicitud'] = $this->_getSanitizedParamHtml("solicitud");
		$data['cedula'] = "";
		$data['desprendible_pago'] = "";
		$data['desprendible_pago2'] = "";
		$data['desprendible_pago3'] = "";
		$data['desprendible_pago4'] = "";
		$data['desprendible_pago5'] = "";
		$data['certificado_laboral'] = "";
		$data['otros_ingresos'] = "";
		$data['certificado_tradicion'] = "";
		$data['estado_obligacion'] = "";
		$data['estado_obligacion2'] = "";
		$data['estado_obligacion3'] = "";
		$data['factura_proforma'] = "";
		$data['recibo_matricula'] = "";
		$data['contrato_vivienda'] = "";
		$data['declaracion_renta'] = "";
		$data['tipo'] = $this->_getSanitizedParamHtml("tipo");

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

		$id= $this->_getSanitizedParam("id");

		$filtros = $filtros." AND solicitud = '$id' ";

		$tipo= $this->_getSanitizedParam("tipo");

		$filtros = $filtros." AND tipo = '$tipo' ";

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

            if ($filters->desprendible_pago5 != '') {

                $filtros = $filtros." AND desprendible_pago5 LIKE '%".$filters->desprendible_pago5."%'";

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

					$parramsfilter['desprendible_pago5'] =  $this->_getSanitizedParam("desprendible_pago5");

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