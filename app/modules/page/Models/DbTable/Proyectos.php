<?php 
/**
* clase que genera la insercion y edicion  de proyectos en la base de datos
*/
class Page_Model_DbTable_Proyectos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'proyectos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un proyecto y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$fecha_c = $data['fecha_c'];
		$nombre = $data['nombre'];
		$tipo = $data['tipo'];
		$valor = $data['valor'];
		$cliente_id = $data['cliente_id'];
		$estado = $data['estado'];
		$documento1 = $data['documento1'];
		$documento2 = $data['documento2'];
		$documento3 = $data['documento3'];
		$proyectos_cadmin = $data['proyectos_cadmin'];
		$proyectos_caprueba = $data['proyectos_caprueba'];
		$consecutivo = $data['consecutivo'];
		$query = "INSERT INTO proyectos( fecha_c, nombre, tipo, valor, cliente_id, estado, documento1, documento2, documento3, proyectos_cadmin, proyectos_caprueba, consecutivo) VALUES ( '$fecha_c', '$nombre', '$tipo', '$valor', '$cliente_id', '$estado', '$documento1', '$documento2', '$documento3', '$proyectos_cadmin', '$proyectos_caprueba', '$consecutivo')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un proyecto  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$fecha_c = $data['fecha_c'];
		$nombre = $data['nombre'];
		$tipo = $data['tipo'];
		$valor = $data['valor'];
		$cliente_id = $data['cliente_id'];
		$estado = $data['estado'];
		$documento1 = $data['documento1'];
		$documento2 = $data['documento2'];
		$documento3 = $data['documento3'];
		$query = "UPDATE proyectos SET  nombre = '$nombre', tipo = '$tipo', valor = '$valor', cliente_id = '$cliente_id', estado = '$estado', documento1 = '$documento1', documento2 = '$documento2', documento3 = '$documento3' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}

    public function getProyectosCliente($filters = '',$order = '')
    {
        $filter = '';
        if($filters != ''){
            $filter = ' WHERE '.$filters;
        }
        $orders ="";
        if($order != ''){
            $orders = ' ORDER BY '.$order;
        }
        $select = 'SELECT proyectos.* FROM '.$this->_name.' LEFT JOIN clientes ON clientes.id = proyectos.cliente_id '.$filter.' '.$orders;
        //echo $select."<br>";
        $res = $this->_conn->query( $select )->fetchAsObject();
        return $res;
    }
    
    public function getMaxClientes() {

		$select = 'SELECT cliente_id, COUNT(*) AS total_proyectos FROM proyectos GROUP BY cliente_id ORDER BY total_proyectos DESC';
        $res = $this->_conn->query( $select )->fetchAsObject();
        return $res;
		
	}

	public function masCotizan($filters = '') {

		$filter = '';
        if($filters != ''){
            $filter = ' WHERE '.$filters;
        }

		$select = 'SELECT c.id AS cliente_id, c.nombre AS cliente_nombre, COUNT(p.id) AS total_cotizaciones, SUM(p.valor) AS total_valor FROM clientes c LEFT JOIN proyectos p ON c.id = p.cliente_id '.$filter.' GROUP BY c.id, c.nombre ORDER BY total_cotizaciones DESC';
        $res = $this->_conn->query( $select )->fetchAsObject();
        return $res;
		
	}

	public function getListPagesIng($filters = '' ,$order = '' ,$page,$amount)
    {
       $filter = '';
        if($filters != ''){
            $filter = ' WHERE '.$filters;
        }
        $orders ="";
        if($order != ''){
            $orders = ' ORDER BY '.$order;
        }
        $select = 'SELECT * FROM proyectos a LEFT JOIN proyectosing b ON a.id = b.proyectosing_proyecto '.$filter.' '.$orders.' LIMIT '.$page.' , '.$amount;
        $res = $this->_conn->query($select)->fetchAsObject();
        return $res;
    }

	public function getListIng($filters = '',$order = '')
    {
        $filter = '';
        if($filters != ''){
            $filter = ' WHERE '.$filters;
        }
        $orders ="";
        if($order != ''){
            $orders = ' ORDER BY '.$order;
        }
        $select = 'SELECT * FROM proyectos a LEFT JOIN proyectosing b ON a.id = b.proyectosing_proyecto '.$filter.' '.$orders;
        //echo $select."<br>";
        $res = $this->_conn->query( $select )->fetchAsObject();
        return $res;
    }

}