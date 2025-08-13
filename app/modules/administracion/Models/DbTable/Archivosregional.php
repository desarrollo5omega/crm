<?php 
/**
* clase que genera la insercion y edicion  de Archivos regional en la base de datos
*/
class Administracion_Model_DbTable_Archivosregional extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'archivos_regional';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'archivo_id';

	/**
	 * insert recibe la informacion de un Archivos Regional y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$archivo_fecha = $data['archivo_fecha'];
		$archivo_archivo = $data['archivo_archivo'];
		$archivo_usuario = $data['archivo_usuario'];
		$query = "INSERT INTO archivos_regional( archivo_fecha, archivo_archivo, archivo_usuario) VALUES ( '$archivo_fecha', '$archivo_archivo', '$archivo_usuario')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un Archivos Regional  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$archivo_fecha = $data['archivo_fecha'];
		$archivo_archivo = $data['archivo_archivo'];
		$archivo_usuario = $data['archivo_usuario'];
		$query = "UPDATE archivos_regional SET  archivo_fecha = '$archivo_fecha', archivo_archivo = '$archivo_archivo', archivo_usuario = '$archivo_usuario' WHERE archivo_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}