<?php 

/**
*
*/

class Page_loginController extends Page_mainController
{

	public function indexAction()
	{
		$this->setLayout('page_login');
	}

	public function loginAction()
	{
		$user = $this->_getSanitizedParam("correo");
		$password = $this->_getSanitizedParam("password");

		$login_codeudor = $this->_getSanitizedParam("login_codeudor");
		$id = $this->_getSanitizedParam("id");
		$e = $this->_getSanitizedParam("e");

		$userModel = new Core_Model_DbTable_User();
		if ($userModel->autenticateUser($user,$password) == true || ($user!="" and $this->_getSanitizedParam('auto_login')=="OMEGA")) {
			$resUser = $userModel->searchUserByUser($user);
			if($resUser->user_state==1){
				Session::getInstance()->set("kt_login_id",$resUser->user_id);
				Session::getInstance()->set("kt_login_level",$resUser->user_level);
				Session::getInstance()->set("kt_login_user",$resUser->user_user);
				Session::getInstance()->set("kt_login_name",$resUser->user_names." ".$resUser->user_lastnames);
				Session::getInstance()->set("kt_cargo",$resUser->user_cargo);

				//LOG
				$resUser->fecha_login = date("d-m-Y H:i:s");
				$data['log_log'] = print_r($resUser,true);
				$data['log_tipo'] = "LOGIN";
				$logModel = new Administracion_Model_DbTable_Log();
				$logModel->insert($data);
				
				if ($resUser->user_level == 5) {
					header("Location:/page/tablero/?ing=".$resUser->user_id);
				} else {
					header("Location:/page/sistema/");
				}
				
			}else{
				header("Location:/page/?correo=".$user."&error=2");
			}
		}else{
			header("Location:/page/?correo=".$user."&error=1");
		}

	}

	public function autenticarAction(){
		$_SESSION['kt_login_id'] = $this->_getSanitizedParam("kt_login_id");
		$_SESSION['kt_login_level'] = $this->_getSanitizedParam("kt_login_level");
		$_SESSION['kt_login_user'] = $this->_getSanitizedParam("kt_login_user");
		$_SESSION['kt_login_name'] = $this->_getSanitizedParam("kt_login_name");
		$_SESSION['kt_names'] = $this->_getSanitizedParam("kt_names");
		$_SESSION['kt_last_names'] = $this->_getSanitizedParam("kt_last_names");
		$this->_view->e = $this->_getSanitizedParam("e");
		$this->_view->id = $this->_getSanitizedParam("id");
		$this->_view->n = $this->_getSanitizedParam("n");
	}


	public function logoutAction()
	{
		Session::getInstance()->set("kt_login_id","");
		Session::getInstance()->set("kt_login_level","");
		Session::getInstance()->set("kt_login_user","");
		Session::getInstance()->set("kt_login_name","");
		Session::getInstance()->set("kt_names","");
		Session::getInstance()->set("kt_last_names","");
		//header('Location://fendesa.com/sistema/panel/');
		header('Location:/page/index');
	}
	public function forgotpassword2Action()
	{
		$this->setLayout('blanco');
        $this->_csrf_section = "login_admin";
        $modelUser = new Core_Model_DbTable_User();
        $cedula = $this->_getSanitizedParam("correo");
        $error = true;
        $message = "Usuario No encontrado";
        $filter = " user_email = '".$cedula."' ";
        //print_r($filter);
        $user = $modelUser->getList($filter, "")[0];
        //print_r($user);
        $id = $user->user_id; 
        $correo = $user->user_email;
        $cc = $user->user_cedula;
        //print_r($id);
        //print_r($correo);
        $correo2 = $correo;
        Session::getInstance()->set("error_olvido",$message);
        $code = Session::getInstance()->get('csrf')['page_csrf'];
        print_r($code);
        if ($user) {
         	$sendingemail = new Core_Model_Sendingemail($this->_view);
            $code = Session::getInstance()->get('csrf')['page_csrf'];
            $modelUser->editCode($id,$code);
            $user = $modelUser->getById($user->user_id);
            $correo = $modelUser->getById($user->user_email);
            //print_r($correo2);
            $cc = $modelUser->getById($user->user_cedula);
            if ($sendingemail->forgotpassword2($user,$correo, $cedula ,$code) == 1 ) {
                $error = 2;
                $message = "Se ha enviado a su correo un mensaje de recuperación de contraseña con la siguiente dirección: ";
                Session::getInstance()->set("mensaje_olvido",$message);
                Session::getInstance()->set("correo_envio",$correo2);
                Session::getInstance()->set("error_olvido","");
            } else {
                $message = "Lo sentimos ocurrio un error y no se pudo enviar su mensaje";
                Session::getInstance()->set("error_olvido",$message);
            }
        }
	    header('Location: /page/index/recordar');
	}

}