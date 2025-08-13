<?php 
/**
* clase que genera la insercion y edicion  de documentos sarlaft en la base de datos
*/
class Administracion_Model_DbTable_Documentossarlaft extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'documentos_sarlaft';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un documentos sarlaft y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$asociado = $data['asociado'];
		$cedula = $data['cedula'];
		$certificado_ingresos = $data['certificado_ingresos'];
		$declaracion_renta = $data['declaracion_renta'];
		$desprendible = $data['desprendible'];
		$anio = $data['anio'];
		$query = "INSERT INTO documentos_sarlaft( asociado, cedula, certificado_ingresos, declaracion_renta, desprendible, anio) VALUES ( '$asociado', '$cedula', '$certificado_ingresos', '$declaracion_renta', '$desprendible', '$anio')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un documentos sarlaft  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$asociado = $data['asociado'];
		$cedula = $data['cedula'];
		$certificado_ingresos = $data['certificado_ingresos'];
		$declaracion_renta = $data['declaracion_renta'];
		$desprendible = $data['desprendible'];
		$anio = $data['anio'];
		$query = "UPDATE documentos_sarlaft SET  asociado = '$asociado', cedula = '$cedula', certificado_ingresos = '$certificado_ingresos', declaracion_renta = '$declaracion_renta', desprendible = '$desprendible', anio = '$anio' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}

    public function editar($field,$value,$asociado,$anio){
        $query =' UPDATE '.$this->_name.' SET '.$field.' = "'.$value.'" WHERE asociado="'.$asociado.'" AND anio="'.$anio.'" ';
        //echo $query."<br>";
        $res = $this->_conn->query($query);
    }

}