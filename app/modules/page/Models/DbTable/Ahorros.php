<?php

/**
*
*/
class Page_Model_DbTable_Ahorros extends Db_Table
{
	//protected $_name = 'fendesa_db.estadocuenta_saldos';
    //protected $_name = 'omegasol_fendesa.estadocuenta_saldos';
    protected $_name = 'omegasol_alquiler_db.estadocuenta_ahorros';
	protected $_id = 'estadocuenta_ahorros_numero';


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