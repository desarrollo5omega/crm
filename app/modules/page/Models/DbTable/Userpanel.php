<?php

/**
*
*/
class Page_Model_DbTable_Userpanel extends Db_Table
{
    protected $_name = 'omegasol_alquiler_db.user';
	protected $_id = 'user_id';


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