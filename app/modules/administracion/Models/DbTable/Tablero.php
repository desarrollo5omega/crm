<?php 
/**
* clase que genera la insercion y edicion  de logs en la base de datos
*/
class Administracion_Model_DbTable_Tablero extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'tablero';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'tablero_id';

	public function insert($data){
		$tablero_proyecto = $data['tablero_proyecto'];
        $tablero_ing = $data['tablero_ing'];
        $tablero_fecha = $data['tablero_fecha'];
        $tablero_all = $data['tablero_all'];
        $tablero_inicia = $data['tablero_inicia'];
        $tablero_fin = $data['tablero_fin'];
        $tablero_dia = $data['tablero_dia'];
		$tablero_color = $data['tablero_color'];
        $tablero_fuente = $data['tablero_fuente'];
		$tablero_estado = $data['tablero_estado'];
		$query = "INSERT INTO tablero (tablero_proyecto, tablero_ing, tablero_fecha, tablero_all, tablero_inicia, tablero_fin, tablero_dia, tablero_color, tablero_fuente, tablero_estado) VALUES ('$tablero_proyecto', '$tablero_ing', '$tablero_fecha', '$tablero_all', '$tablero_inicia', '$tablero_fin', '$tablero_dia', '$tablero_color', '$tablero_fuente', '$tablero_estado')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

}