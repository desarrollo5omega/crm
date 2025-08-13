<?php

/**
*
*/
class Page_Model_DbTable_Usuarios extends Db_Table
{
	//protected $_name = 'fendesa_db.estadocuenta_saldos';
    //protected $_name = 'omegasol_fendesa.estadocuenta_saldos';
    protected $_name = 'user';
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