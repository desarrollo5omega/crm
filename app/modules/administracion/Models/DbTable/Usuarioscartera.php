<?php 
/**
* clase que genera la insercion y edicion  de Usuarios Compra de Cartera en la base de datos
*/
class Administracion_Model_DbTable_Usuarioscartera extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'usuarios_cartera';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'userc_id';

	/**
	 * insert recibe la informacion de un Usuarios Compra de Cartera y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$userc_cedula = $data['userc_cedula'];
		$userc_nombre = $data['userc_nombre'];
		$userc_regional = $data['userc_regional'];
		$userc_cargo = $data['userc_cargo'];
		$userc_estado = $data['userc_estado'];
		$userc_salario = $data['userc_salario'];
		$userc_afiliacion = $data['userc_afiliacion'];
		$userc_antiguedad = $data['userc_antiguedad'];
		$userc_vinculacion = $data['userc_vinculacion'];
		$userc_anti_empresa = $data['userc_anti_empresa'];
		$userc_aportes = $data['userc_aportes'];
		$userc_cartera = $data['userc_cartera'];
		$userc_cupo = $data['userc_cupo'];
		$userc_capacidad = $data['userc_capacidad'];
		$userc_prestamo = $data['userc_prestamo'];
		$query = "INSERT INTO usuarios_cartera( userc_cedula, userc_nombre, userc_regional, userc_cargo, userc_estado, userc_salario, userc_afiliacion, userc_antiguedad, userc_vinculacion, userc_anti_empresa, userc_aportes, userc_cartera, userc_cupo, userc_capacidad, userc_prestamo) VALUES ( '$userc_cedula', '$userc_nombre', '$userc_regional', '$userc_cargo', '$userc_estado', '$userc_salario', '$userc_afiliacion', '$userc_antiguedad', '$userc_vinculacion', '$userc_anti_empresa', '$userc_aportes', '$userc_cartera', '$userc_cupo', '$userc_capacidad', '$userc_prestamo')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un Usuarios Compra de Cartera  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$userc_cedula = $data['userc_cedula'];
		$userc_nombre = $data['userc_nombre'];
		$userc_regional = $data['userc_regional'];
		$userc_cargo = $data['userc_cargo'];
		$userc_estado = $data['userc_estado'];
		$userc_salario = $data['userc_salario'];
		$userc_afiliacion = $data['userc_afiliacion'];
		$userc_antiguedad = $data['userc_antiguedad'];
		$userc_vinculacion = $data['userc_vinculacion'];
		$userc_anti_empresa = $data['userc_anti_empresa'];
		$userc_aportes = $data['userc_aportes'];
		$userc_cartera = $data['userc_cartera'];
		$userc_cupo = $data['userc_cupo'];
		$userc_capacidad = $data['userc_capacidad'];
		$userc_prestamo = $data['userc_prestamo'];
		$query = "UPDATE usuarios_cartera SET  userc_cedula = '$userc_cedula', userc_nombre = '$userc_nombre', userc_regional = '$userc_regional', userc_cargo = '$userc_cargo', userc_estado = '$userc_estado', userc_salario = '$userc_salario', userc_afiliacion = '$userc_afiliacion', userc_antiguedad = '$userc_antiguedad', userc_vinculacion = '$userc_vinculacion', userc_anti_empresa = '$userc_anti_empresa', userc_aportes = '$userc_aportes', userc_cartera = '$userc_cartera', userc_cupo = '$userc_cupo', userc_capacidad = '$userc_capacidad', userc_prestamo = '$userc_prestamo' WHERE userc_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
	public function truncate(){
		
		$query = " TRUNCATE usuarios_cartera  ";
		$res = $this->_conn->query($query);
	}
}