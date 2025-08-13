<?php 
/**
* clase que genera la insercion y edicion  de referencias en la base de datos
*/
class Administracion_Model_DbTable_Referencias extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'referencias';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un referencia y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$solicitud = $data['solicitud'];
		$tipo = $data['tipo'];
		$numero = $data['numero'];
		$nombres = $data['nombres'];
		$parentesco = $data['parentesco'];
		$direccion = $data['direccion'];
		$ciudad = $data['ciudad'];
		$telefono = $data['telefono'];
		$celular = $data['celular'];
		$departamento = $data['departamento'];
		$actividad = $data['actividad'];
		$empresa = $data['empresa'];
		$cargo = $data['cargo'];
		$telefono_empresa = $data['telefono_empresa'];
		$nomenclatura = $data['nomenclatura'];
		$correo = $data['correo'];
		$query = "INSERT INTO referencias( solicitud, tipo, numero, nombres, parentesco, direccion, ciudad, telefono, celular, departamento, actividad, empresa, cargo, telefono_empresa, nomenclatura, correo) VALUES ( '$solicitud', '$tipo', '$numero', '$nombres', '$parentesco', '$direccion', '$ciudad', '$telefono', '$celular', '$departamento', '$actividad', '$empresa', '$cargo', '$telefono_empresa', '$nomenclatura', '$correo')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un referencia  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){

		$solicitud = $data['solicitud'];
		$tipo = $data['tipo'];
		$numero = $data['numero'];
		$nombres = $data['nombres'];
		$parentesco = $data['parentesco'];
		$direccion = $data['direccion'];
		$ciudad = $data['ciudad'];
		$telefono = $data['telefono'];
		$celular = $data['celular'];
		$departamento = $data['departamento'];
		$actividad = $data['actividad'];
		$empresa = $data['empresa'];
		$cargo = $data['cargo'];
		$telefono_empresa = $data['telefono_empresa'];
		$nomenclatura = $data['nomenclatura'];
		$correo = $data['correo'];
		$query = "UPDATE referencias SET  solicitud = '$solicitud', tipo = '$tipo', numero = '$numero', nombres = '$nombres', parentesco = '$parentesco', direccion = '$direccion', ciudad = '$ciudad', telefono = '$telefono', celular = '$celular', departamento = '$departamento', actividad = '$actividad', empresa = '$empresa', cargo = '$cargo', telefono_empresa = '$telefono_empresa', nomenclatura='$nomenclatura', correo='$correo' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}

	public function borrar($id){

		$query = " DELETE FROM  referencias WHERE  solicitud = '$id' ";
		$res = $this->_conn->query($query);
	}

}