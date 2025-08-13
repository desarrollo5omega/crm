<?php 
/**
* clase que genera la insercion y edicion  de actascomiteitems en la base de datos
*/
class Administracion_Model_DbTable_Actascomiteitems extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'actas_comite_items';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'aci_id';

	/**
	 * insert recibe la informacion de un actascomiteitems y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$aci_acta_id = $data['aci_acta_id'];
		$aci_solicitud_id = $data['aci_solicitud_id'];
		$aci_fecha = $data['aci_fecha'];
		$query = "INSERT INTO actas_comite_items( aci_acta_id, aci_solicitud_id, aci_fecha) VALUES ( '$aci_acta_id', '$aci_solicitud_id', '$aci_fecha')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un actascomiteitems  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$aci_acta_id = $data['aci_acta_id'];
		$aci_solicitud_id = $data['aci_solicitud_id'];
		$aci_fecha = $data['aci_fecha'];
		$query = "UPDATE actas_comite_items SET  aci_acta_id = '$aci_acta_id', aci_solicitud_id = '$aci_solicitud_id', aci_fecha = '$aci_fecha' WHERE aci_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}