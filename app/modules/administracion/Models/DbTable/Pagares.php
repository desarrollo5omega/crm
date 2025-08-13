<?php 
/**
* clase que genera la insercion y edicion  de pagares en la base de datos
*/
class Administracion_Model_DbTable_Pagares extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'pagare_deceval';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un pagares y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$pagare = $data['pagare'];
		$pagare_deceval = $data['pagare_deceval'];
		$fecha = $data['fecha'];
		$estado = $data['estado'];
		$token = $data['token'];
		$modalidad = $data['modalidad'];
		$fecha_firma = $data['fecha_firma'];
		$ip = $data['ip'];
		$fecha_firma1 = $data['fecha_firma1'];
		$ip1 = $data['ip1'];
		$fecha_firma2 = $data['fecha_firma2'];
		$ip2 = $data['ip2'];
		$query = "INSERT INTO pagare_deceval( pagare, pagare_deceval, fecha, estado, token, modalidad, fecha_firma, ip, fecha_firma1, ip1, fecha_firma2, ip2) VALUES ( '$pagare', '$pagare_deceval', '$fecha', '$estado', '$token', '$modalidad', '$fecha_firma', '$ip', '$fecha_firma1', '$ip1', '$fecha_firma2', '$ip2')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un pagares  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$pagare = $data['pagare'];
		$pagare_deceval = $data['pagare_deceval'];
		$fecha = $data['fecha'];
		$estado = $data['estado'];
		$token = $data['token'];
		$modalidad = $data['modalidad'];
		$fecha_firma = $data['fecha_firma'];
		$ip = $data['ip'];
		$fecha_firma1 = $data['fecha_firma1'];
		$ip1 = $data['ip1'];
		$fecha_firma2 = $data['fecha_firma2'];
		$ip2 = $data['ip2'];
		$query = "UPDATE pagare_deceval SET  pagare = '$pagare', pagare_deceval = '$pagare_deceval', fecha = '$fecha', estado = '$estado', token = '$token', modalidad = '$modalidad', fecha_firma = '$fecha_firma', ip = '$ip', fecha_firma1 = '$fecha_firma1', ip1 = '$ip1', fecha_firma2 = '$fecha_firma2', ip2 = '$ip2' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}

    public function getList2($filters = '',$order = '')
    {
        $filter = '';
        if($filters != ''){
            $filter = ' WHERE '.$filters;
        }
        $orders ="";
        if($order != ''){
            $orders = ' ORDER BY '.$order;
        }
        $select = 'SELECT * FROM '.$this->_name.' LEFT JOIN solicitudes ON solicitudes.pagare = pagare_deceval.pagare '.$filter.' '.$orders;
        //echo $select."<br>";
        $res = $this->_conn->query( $select )->fetchAsObject();
        return $res;
    }

}