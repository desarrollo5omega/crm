<?php

/**
*
*/
class Page_Model_DbTable_Aportes extends Db_Table
{
    protected $_name = 'omegasol_alquiler_db.aportes';
	protected $_id = 'id';


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