<?php 

/**

* clase que genera la insercion y edicion  de transaccion en la base de datos

*/

class Page_Model_DbTable_Transaccion extends Db_Table

{

	/**

	 * [ nombre de la tabla actual]

	 * @var string

	 */

	protected $_name = 'transacciones';



	/**

	 * [ identificador de la tabla actual en la base de datos]

	 * @var string

	 */

	protected $_id = 'id';



	/**

	 * insert recibe la informacion de un transaccion y la inserta en la base de datos

	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos

	 * @return integer      identificador del  registro que se inserto

	 */

	public function insert($data){

		$metodo = $data['metodo'];

		$xml = $data['xml'];

		$res = $data['res'];

		$exitoso = $data['exitoso'];

		$codigoError = $data['codigoError'];

		$fecha = $data['fecha'];

		$solicitud = $data['solicitud'];

		$numero_solicitud = $data['numero_solicitud'];

		$ip = $data['ip'];

		$quien = $data['quien'];

		$query = "INSERT INTO transacciones( metodo, xml, res, exitoso, codigoError, fecha, solicitud, numero_solicitud, ip, quien) VALUES ( '$metodo', '$xml', '$res', '$exitoso', '$codigoError', '$fecha', '$solicitud', '$numero_solicitud', '$ip', '$quien')";

		$res = $this->_conn->query($query);

        return mysqli_insert_id($this->_conn->getConnection());

	}



	/**

	 * update Recibe la informacion de un transaccion  y actualiza la informacion en la base de datos

	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos

	 * @param  integer    identificador al cual se le va a realizar la actualizacion

	 * @return void

	 */

	public function update($data,$id){

		

		$metodo = $data['metodo'];

		$xml = $data['xml'];

		$res = $data['res'];

		$exitoso = $data['exitoso'];

		$codigoError = $data['codigoError'];

		$fecha = $data['fecha'];

		$solicitud = $data['solicitud'];

		$numero_solicitud = $data['numero_solicitud'];

		$ip = $data['ip'];

		$quien = $data['quien']; $query = "UPDATE transacciones SET  metodo = '$metodo', xml = '$xml', res = '$res', exitoso = '$exitoso', codigoError = '$codigoError', fecha = '$fecha', solicitud = '$solicitud', numero_solicitud = '$numero_solicitud', ip = '$ip', quien = '$quien' WHERE id = '".$id."'";

		$res = $this->_conn->query($query);

	}

}