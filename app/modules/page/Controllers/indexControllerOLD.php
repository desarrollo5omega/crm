<?php

/**
*
*/

class Page_indexController extends Page_mainController
{

	public function indexAction()
	{

		$this->_view->seccion = 1;
		$this->_view->contenidos = $this->template->getContent(1);

		$header = $this->_view->getRoutPHP('modules/page/Views/partials/header.php');
		$this->getLayout()->setData("header",$header);
		$this->getLayout()->setData("es_login",1);

	}
    public function indexinactiveAction()
  {
    $this->_view->seccion = 1;
    $this->_view->contenidos = $this->template->getContent(1);

    $header = $this->_view->getRoutPHP('modules/page/Views/partials/header.php');
    $this->getLayout()->setData("header",$header);

  }

	public function nopermitidoAction()
	{
		$this->_view->seccion = 1;
		$this->_view->contenidos = $this->template->getContent(1);

		$header = $this->_view->getRoutPHP('modules/page/Views/partials/header.php');
		$this->getLayout()->setData("header",$header);


	}
public function recordarAction(){
	$this->_view->seccion = 1;
		$this->_view->contenidos = $this->template->getContent(1);

		$header = $this->_view->getRoutPHP('modules/page/Views/partials/header.php');
		$this->getLayout()->setData("header",$header);
		$this->_view->error_olvido = Session::getInstance()->get("error_olvido");
		Session::getInstance()->set("error_olvido","");
		$this->_view->mensaje_olvido = Session::getInstance()->get("mensaje_olvido");
		Session::getInstance()->set("mensaje_olvido","");
		
		$this->_view->correo_envio = $this->hideEmail(Session::getInstance()->get("correo_envio"));
		Session::getInstance()->set("correo_envio","");
		
		$modelUser = new Core_Model_DbTable_User();
		$user = $modelUser->getList($filter, "")[0];
		$correo = $user->user_email;
}
public function changepasswordAction()
{ 
   
	$user = $this->validarCodigo();
	//print_r($user);
	if (isset($user['error'])) {
		if ($user['error'] == 1) {
			$this->_view->error = "Lo sentimos este codigo ya fue utilizado.";
		} else {
			$this->_view->error = "La información Suministrada es invalida.";
		}
	} else {
		$this->_view->usuario = $user['user']->user_user;
		// new Core_Model_Csrf('nueva_contrasena');
		// $csrf = Session::getInstance()->get('csrf')['nueva_contrasena'];
		$password = $this->_getSanitizedParam("password");
		$re_password = $this->_getSanitizedParam("re_password");
		if ($password == $re_password && $password!="") {
			$id_user = $user['user']->user_id;
			$modelUser = new Core_Model_DbTable_User();
			$modelUser->changePassword($id_user, $password);
			$modelUser->editCode($id_user, $csrf);
			$this->_view->message = "Se ha cambiado su contraseña satisfactoriamente.";
		} else {
			$this->_view->code = $this->_getSanitizedParam("code");
			$this->_view->usuario = $user['user']->user_user;
			$this->_view->csrf = $this->_getSanitizedParam("csrf");
		}
	}
}

protected function validarCodigo()
{
	$res = [];
	$code =  base64_decode($this->_getSanitizedParam("code"));
	if (isset($code) && $this->isJson($code)== true) {
		$code = json_decode($code, true);
		$modelUser = new Core_Model_DbTable_User();
		//echo "hola".$code['user'];
		if (isset($code['user'])) {
			$user = $modelUser->getById($code['user']);
			if (isset($user->user_id)) {
				if ($user->user_code == $code['code']) {
					$res['user'] = $user;
				} else {
					$res['error'] =  1;
					$res['user'] = $user;
				}
			} else {
				$res['error'] =  2;
			}
		} else {
			$res['error'] =  3;
		}
	} else {
		$res['error'] =  4;
	}
	return $res;
}

 private function isJson($string)
{
	return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
}


function hideEmail($email)
{
$parts = explode('@', $email);
return substr($parts[0], 0, min(1, strlen($parts[0])-1)) . str_repeat('*', max(1, strlen($parts[0]) - 1)) . '@' . $parts[1];
}
/* public function infoAction(){
	phpinfo();
	} */
}