<?php 

/**
*
*/

class Administracion_consultasController extends Administracion_mainController
{

    public $botonpanel = 12;
    /**
     * $mainModel  instancia del modelo de  base de datos solicitudes
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
    protected $_csrf_section = "administracion_solicitudes";

    /**
     * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
     * @var string
     */
    protected $namepages;



	public function indexAction()
	{
        $title = "Consultas";
        $this->getLayout()->setTitle($title);
        $this->_view->titlesection = $title;

	}

    public function pagaresAction(){
        $title = "Consultar pagares";
        $this->getLayout()->setTitle($title);
        $this->_view->titlesection = $title;

        $pagaresModel = new Administracion_Model_DbTable_Pagares();
        $usuariosinfoModel = new Administracion_Model_DbTable_Usuariosinfo();
        $cedula = $this->_getSanitizedParam("cedula");
        $pagares = $pagaresModel->getList2(" estado = '1' AND solicitudes.cedula = '$cedula' ","");
        foreach ($pagares as $key => $pagare) {
            $codeudor1 = $pagare->codeudor1;
            $codeudor2 = $pagare->codeudor2;
            if($codeudor1!=""){
                $codeudor1_list = $usuariosinfoModel->getList(" documento = '$codeudor1' ","");
                $pagare->nombre_codeudor1 = $codeudor1_list[0]->nombres." ".$codeudor1_list[0]->apellidos;
            }
            if($codeudor2!=""){
                $codeudor2_list = $usuariosinfoModel->getList(" documento = '$codeudor2' ","");
                $pagare->nombre_codeudor2 = $codeudor2_list[0]->nombres." ".$codeudor2_list[0]->apellidos;
            }

        }
        $this->_view->pagares = $pagares;
    }

    public function cuposAction(){
        $title = "Consultar cupos";
        $this->getLayout()->setTitle($title);
        $this->_view->titlesection = $title;

        $cuposModel = new Administracion_Model_DbTable_Cuposlinea();
        $usuariosinfoModel = new Administracion_Model_DbTable_Usuariosinfo();
        $lineaModel = new Administracion_Model_DbTable_Lineas();
        $cedula = $this->_getSanitizedParam("cedula");
        $cupos = $cuposModel->getList(" cedula = '$cedula' ","");
        foreach ($cupos as $key => $cupo) {
            $cupo->usuario = $usuariosinfoModel->getList(" documento = '$cedula' ","")[0];
            $linea = $cupo->linea;
            $cupo->linea_list = $lineaModel->getList(" codigo = '$linea' ","")[0];
        }
        $this->_view->cupos = $cupos;
    }

    public function solicitudesAction(){
        $title = "Consultar solicitudes";
        $this->getLayout()->setTitle($title);
        $this->_view->titlesection = $title;

        $usuariosinfoModel = new Administracion_Model_DbTable_Usuariosinfo();
        $lineaModel = new Administracion_Model_DbTable_Lineas();
        $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
        $usuarioModel = new Administracion_Model_DbTable_Usuario();
        $cedula = $this->_getSanitizedParam("cedula");
        $solicitudes = $solicitudModel->getList(" cedula = '$cedula' AND paso='7' ","");
        foreach ($solicitudes as $key => $solicitud) {
            $asignado = $solicitud->asignado;
            $solicitud->analista = $usuarioModel->getList(" user_id = '$asignado' ","")[0];
            $linea = $solicitud->linea;
            $solicitud->linea_list = $lineaModel->getList(" id = '$linea' ","")[0];
        }
        $this->_view->solicitudes = $solicitudes;
    }

    public function informacionAction(){
        $title = "Consultar información";
        $this->getLayout()->setTitle($title);
        $this->_view->titlesection = $title;

        $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
        $cedula = $this->_getSanitizedParam("cedula");
        $solicitudes = $solicitudModel->getList(" cedula = '$cedula' AND paso='7' "," id DESC ");
        $this->_view->solicitudes = $solicitudes;
    }

}