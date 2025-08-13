<?php 
/**
* clase que genera la insercion y edicion  de info financiera en la base de datos
*/
class Administracion_Model_DbTable_Infofinanciera extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'info_financiera';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un info financiera y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$solicitud = $data['solicitud'];
		$cedula = $data['cedula'];
		$salario = $data['salario'];
		$pension = $data['pension'];
		$arriendos = $data['arriendos'];
		$dividendos = $data['dividendos'];
		$rentas = $data['rentas'];
		$otros_ingresos = $data['otros_ingresos'];
		$total_ingresos = $data['total_ingresos'];
		$arrendamientos = $data['arrendamientos'];
		$gastos_familiares = $data['gastos_familiares'];
		$obligaciones_financieras = $data['obligaciones_financieras'];
		$otros_gastos = $data['otros_gastos'];
		$total_gastos = $data['total_gastos'];
		$capacidad_endeudamiento = $data['capacidad_endeudamiento'];
		$query = "INSERT INTO info_financiera( solicitud, cedula, salario, pension, arriendos, dividendos, rentas, otros_ingresos, total_ingresos, arrendamientos, gastos_familiares, obligaciones_financieras, otros_gastos, total_gastos, capacidad_endeudamiento) VALUES ( '$solicitud', '$cedula', '$salario', '$pension', '$arriendos', '$dividendos', '$rentas', '$otros_ingresos', '$total_ingresos', '$arrendamientos', '$gastos_familiares', '$obligaciones_financieras', '$otros_gastos', '$total_gastos', '$capacidad_endeudamiento')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un info financiera  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$solicitud = $data['solicitud'];
		$cedula = $data['cedula'];
		$salario = $data['salario'];
		$pension = $data['pension'];
		$arriendos = $data['arriendos'];
		$dividendos = $data['dividendos'];
		$rentas = $data['rentas'];
		$otros_ingresos = $data['otros_ingresos'];
		$total_ingresos = $data['total_ingresos'];
		$arrendamientos = $data['arrendamientos'];
		$gastos_familiares = $data['gastos_familiares'];
		$obligaciones_financieras = $data['obligaciones_financieras'];
		$otros_gastos = $data['otros_gastos'];
		$total_gastos = $data['total_gastos'];
		$capacidad_endeudamiento = $data['capacidad_endeudamiento'];
		$query = "UPDATE info_financiera SET  solicitud = '$solicitud', cedula = '$cedula', salario = '$salario', pension = '$pension', arriendos = '$arriendos', dividendos = '$dividendos', rentas = '$rentas', otros_ingresos = '$otros_ingresos', total_ingresos = '$total_ingresos', arrendamientos = '$arrendamientos', gastos_familiares = '$gastos_familiares', obligaciones_financieras = '$obligaciones_financieras', otros_gastos = '$otros_gastos', total_gastos = '$total_gastos', capacidad_endeudamiento = '$capacidad_endeudamiento' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}

	public function borrar($id,$cedula){

		$query = " DELETE FROM info_financiera WHERE solicitud = '".$id."' AND cedula='$cedula' ";
		$res = $this->_conn->query($query);
	}

}