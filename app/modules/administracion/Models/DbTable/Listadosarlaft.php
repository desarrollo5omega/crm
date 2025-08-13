<?php 

/**

* clase que genera la insercion y edicion  de Listado Sarlaft en la base de datos

*/

class Administracion_Model_DbTable_Listadosarlaft extends Db_Table

{

	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */

	protected $_name = 'sarlaft_actualizado';
	/**

	 * [ identificador de la tabla actual en la base de datos]

	 * @var string

	 */

	protected $_id = 'id';



	/**
	 * insert recibe la informacion de un Listado Sarlaft y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto

	 */

	public function insert($data){
		$cedula = $data['cedula'];
	$fecha = $data['fecha'];
	$query = "INSERT INTO sarlaft_actualizado( cedula, fecha) VALUES ( '$cedula', '$fecha')";
	$res = $this->_conn->query($query);

        return mysqli_insert_id($this->_conn->getConnection());

	}



	/**

	 * update Recibe la informacion de un Listado Sarlaft  y actualiza la informacion en la base de datos

	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos

	 * @param  integer    identificador al cual se le va a realizar la actualizacion

	 * @return void

	 */

	public function update($data,$id){

		$cedula = $data['cedula'];
		$fecha = $data['fecha'];
		$query = "UPDATE sarlaft_actualizado SET  cedula = '$cedula', fecha = '$fecha' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);

	}


    public function getList($filters = '',$order = '')
    {
        $filter = '';
        if($filters != ''){
            $filter = ' WHERE '.$filters;
        }
        $orders ="";
        if($order != ''){
            $orders = ' ORDER BY '.$order;
        }
        $select = 'SELECT * FROM '.$this->_name.' LEFT JOIN usuarios_info ON sarlaft_actualizado.cedula = usuarios_info.documento '.$filter.' '.$orders;
        //echo $select."<br>";
        $res = $this->_conn->query( $select )->fetchAsObject();
        return $res;
    }


    public function getListPages($filters = '' ,$order = '' ,$page,$amount)
    {
       $filter = '';
        if($filters != ''){
            $filter = ' WHERE '.$filters;
        }
        $orders ="";
        if($order != ''){
            $orders = ' ORDER BY '.$order;
        }
        $select = 'SELECT * FROM '.$this->_name.' LEFT JOIN usuarios_info ON sarlaft_actualizado.cedula = usuarios_info.documento '.$filter.' '.$orders.' LIMIT '.$page.' , '.$amount;
        $res = $this->_conn->query($select)->fetchAsObject();
        return $res;
    }

}