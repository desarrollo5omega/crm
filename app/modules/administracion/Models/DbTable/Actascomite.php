<?php 
/**
* clase que genera la insercion y edicion  de actas comite en la base de datos
*/
class Administracion_Model_DbTable_Actascomite extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'actas_comite';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'acta_id';

	/**
	 * insert recibe la informacion de un acta comite y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$acta_fecha = $data['acta_fecha'];
		$acta_tipo = $data['acta_tipo'];
		$acta_asistentes = $data['acta_asistentes'];
		$acta_presidente = $data['acta_presidente'];
		$acta_secretaria = $data['acta_secretaria'];
		$acta_cabecera = $data['acta_cabecera'];
		$acta_cuerpo = $data['acta_cuerpo'];
		$acta_consecutivo = $data['acta_consecutivo'];
		$query = "INSERT INTO actas_comite( acta_fecha, acta_tipo, acta_asistentes, acta_presidente, acta_secretaria, acta_cabecera, acta_cuerpo, acta_consecutivo) VALUES ( '$acta_fecha', '$acta_tipo', '$acta_asistentes', '$acta_presidente', '$acta_secretaria', '$acta_cabecera', '$acta_cuerpo','$acta_consecutivo')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un acta comite  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){

		$acta_fecha = $data['acta_fecha'];
		$acta_tipo = $data['acta_tipo'];
		$acta_asistentes = $data['acta_asistentes'];
		$acta_presidente = $data['acta_presidente'];
		$acta_secretaria = $data['acta_secretaria'];
		$acta_cabecera = $data['acta_cabecera'];
		$acta_cuerpo = $data['acta_cuerpo'];
		$acta_consecutivo = $data['acta_consecutivo'];
		$query = "UPDATE actas_comite SET  acta_fecha = '$acta_fecha', acta_tipo = '$acta_tipo', acta_asistentes = '$acta_asistentes', acta_presidente = '$acta_presidente', acta_secretaria = '$acta_secretaria', acta_cabecera = '$acta_cabecera', acta_cuerpo = '$acta_cuerpo', acta_consecutivo='$acta_consecutivo' WHERE acta_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}