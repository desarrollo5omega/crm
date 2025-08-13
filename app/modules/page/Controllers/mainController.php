<?php 

/**
*
*/

class Page_mainController extends Controllers_Abstract
{

	public $template;

	public function init()
	{
		$this->setLayout('page_page');
		$this->template = new Page_Model_Template_Template($this->_view);
		
		$header = $this->_view->getRoutPHP('modules/page/Views/partials/header.php');
		$this->getLayout()->setData("header",$header);
		$footer = $this->_view->getRoutPHP('modules/page/Views/partials/footer.php');
		$botones = $this->_view->getRoutPHP('modules/page/Views/partials/botones.php');
		$this->getLayout()->setData("footer",$footer);
		$this->getLayout()->setData("botones",$botones);
		$this->usuario();
		$this->_view->editoromega = 1;

		$level = $_SESSION["kt_login_level"];
		$this->_view->level = $level;
		$this->_view->dnone = $this->permision($level);

	    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
	    $this->getLayout()->setData("header", $header);

		$this->_view->botonpanel = $panel = $this->botonpanel;
		$this->_view->permisos = $permisos = $this->modulos();

		$inactivo = 9000000;
		if (Session::getInstance()->get('tiempo') != '') {
			$vida_session = time() - Session::getInstance()->get('tiempo');
			if ($vida_session > $inactivo) {
				session_destroy();
				header('Location: /page/?inactividad==1');
			}
		}

		Session::getInstance()->set("tiempo", time());

		// Extrae solo la ruta sin parámetros
        $uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        
        $whiteList = [
            "/page/login/logout",
            "/page/login/login",
            "/page",
            "/page/seguimientoproyecto/envioaviso"
        ];
        
        if (in_array($uri, $whiteList)) {
            return;
            exit;
        }
        
        
        // Validación de sesión activa
        if (
            Session::getInstance()->get("kt_login_id") < 0 ||
            Session::getInstance()->get("kt_login_id", "") == '' ||
            Session::getInstance()->get("kt_login_level", "") == ''
        ) {
            // Redirige solo si no estamos en la página de login
            if ($uri !== "/page") {
                header('Location: /page/');
                exit;
            }
        }
        
        // Validación de permisos
        if (Session::getInstance()->get("kt_login_id")) {
            if (!in_array($this->botonpanel, $permisos)) {
                if ($uri !== "/page/403") {
                    header('Location: /page/403');
                    exit;
                }
            }
        }
        
        // Control de inactividad
        $inactivo = 9000000;
        if (Session::getInstance()->get('tiempo') != '') {
            $vida_session = time() - Session::getInstance()->get('tiempo');
            if ($vida_session > $inactivo) {
                session_destroy();
                header('Location: /page/?inactividad=1');
                exit;
            }
        }
        
        // Actualiza el tiempo de actividad
        Session::getInstance()->set("tiempo", time());

	}


	public function usuario(){
		$userModel = new Core_Model_DbTable_User();
		$user = $userModel->getById(Session::getInstance()->get("kt_login_id"));
		if($user->user_id == 1){
			$this->editarpage = 1;
		}
	}


	public function changepageAction()
	{
		Session::getInstance()->set($this->namepages,$this->_getSanitizedParam("pages"));
	}

	public function orderAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf ) {
			$id1 =  $this->_getSanitizedParam("id1");
			$id2 =  $this->_getSanitizedParam("id2");
			if (isset($id1) && $id1 > 0 && isset($id2) && $id2 > 0) {
				$content1 = $this->mainModel->getById($id1);
				$content2 = $this->mainModel->getById($id2);
				if (isset($content1) && isset($content2)) {
					$order1 = $content1->orden;
					$order2 = $content2->orden;
					$this->mainModel->changeOrder($order2,$id1);
					$this->mainModel->changeOrder($order1,$id2);
				}
			}
		}
	}	

	function permision($level){
	
		if ($level == 1 || $level == 2) {
			$dnone = "d-none";
		}elseif ($level == 3) { // Proyectos
			$dnone = "d-none";
		}elseif ($level == 4) { // Administrativo
			$dnone = "d-none";
		}else{
			$dnone = "";
		}
		return $dnone;
	}

	public function modulos(){

		$modulosModel = new Page_Model_DbTable_Moduser();
		$level = Session::getInstance()->get("kt_login_level");
		$permisos = $modulosModel->getList(" moduser_user = '$level' ","");

		$array = array();
		foreach ($permisos as $valor) {
			$array[] = $valor->moduser_modulo;
		}

		return $array;
	}

}