<?php

/**
*
*/
class Page_Model_DbTable_Sarlaft extends Db_Table
{
    protected $_name = 'sarlaft_actualizado';
	protected $_id = 'id';


    public function insert($data){
        $documento = $data['documento'];
        $query = " INSERT INTO sarlaft_actualizado (cedula) VALUES ( '$documento')";
        $res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
    }

    public function getList($filters = '',$order = '')
    {
        $filter = '';
        if($filters != ''){
            $filter = ' WHERE '.$filters;
        }
        $orders ="";
        if($order != ''){
            $orders = ' ORDER BY '.$order;
        }
        $select = ' SELECT * FROM '.$this->_name.' '.$filter.' '.$orders;
        //return $select;
        $res = $this->_conn->query( $select )->fetchAsObject();
        return $res;
    }

}