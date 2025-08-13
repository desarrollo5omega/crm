<?php 
/**
* clase que genera la insercion y edicion  de logs en la base de datos
*/
class Administracion_Model_DbTable_Log extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'log';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'log_id';

	public function insert($data){
		$log_usuario = $data['log_usuario'];
		$log_tipo = $data['log_tipo'];
		$log_log = $data['log_log'];
		$log_fecha = date("Y-m-d H:i:s");
		if($_SESSION['kt_login_user']!=""){
			$log_usuario = $_SESSION['kt_login_user'];
		}
		$query = "INSERT INTO log( log_usuario, log_tipo, log_fecha, log_log) VALUES ( '$log_usuario', '$log_tipo', '$log_fecha', '$log_log')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

    public function getTipos($filters = '',$order = '')
    {
        $filter = '';
        if($filters != ''){
            $filter = ' WHERE '.$filters;
        }
        $orders ="";
        if($order != ''){
            $orders = ' ORDER BY '.$order;
        }
        $select = 'SELECT log_tipo FROM '.$this->_name.' '.$filter.' GROUP BY log_tipo '.$orders;
        $res = $this->_conn->query( $select )->fetchAsObject();
        return $res;
    }

}