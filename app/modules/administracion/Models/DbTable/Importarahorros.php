<?php 
/**
* clase que genera la insercion y edicion  de importar aportes y ahorros en la base de datos
*/
class Administracion_Model_DbTable_Importarahorros extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'archivos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un importar aportes y ahorros y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$archivo = $data['archivo'];
		$archivo2 = $data['archivo2'];
		$archivo3 = $data['archivo3'];
		$archivo4 = $data['archivo4'];
		$archivo_inactivos = $data['archivo_inactivos'];
		$query = "INSERT INTO archivos( archivo, archivo2, archivo3, archivo4, archivo_inactivos) VALUES ( '$archivo', '$archivo2', '$archivo3', '$archivo4', '$archivo_inactivos')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un importar aportes y ahorros  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$archivo = $data['archivo'];
		$archivo2 = $data['archivo2'];
		$archivo3 = $data['archivo3'];
		$archivo4 = $data['archivo4'];
		$archivo_inactivos = $data['archivo_inactivos'];
		$query = "UPDATE archivos SET  archivo = '$archivo', archivo2 = '$archivo2', archivo3 = '$archivo3', archivo4 = '$archivo4', archivo_inactivos = '$archivo_inactivos' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}