<?php

/**
*
*/
class Page_Model_DbTable_Saldos extends Db_Table
{
	//protected $_name = 'fendesa_db.estadocuenta_saldos';
    //protected $_name = 'omegasol_fendesa.estadocuenta_saldos';
    protected $_name = 'saldos';
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

        
       
        public function insert($data){
            $estadocuenta_saldos_cedula = $data['estadocuenta_saldos_cedula'];
            $estadocuenta_saldos_linea = $data['estadocuenta_saldos_linea'];
            $linea = $data['linea'];
            $monto = $data['monto'];
            $plazo = $data['plazo'];
            $saldoactual = $data['saldoactual'];
            $saldomora = $data['saldomora'];
            $fhaprcita = $data['fhaprcita'];
            $vence = $data['vence'];    
            $ncuotas = $data['ncuotas'];    
            $cuotafija = $data['cuotafija']; 
            $pagare = $data['pagare']; 
            $valormora = $data['valormora'];     
            $capitalmora = $data['capitalmora'];   
            $query = "INSERT INTO saldos( estadocuenta_saldos_cedula, estadocuenta_saldos_linea, linea,monto,plazo,saldoactual,saldomora,fhaprcita,vence,ncuotas,cuotafija,pagare,valormora,capitalmora) VALUES ( '$estadocuenta_saldos_cedula', '$estadocuenta_saldos_linea', '$linea','$monto','$plazo','$saldoactual','$saldomora','$fhaprcita','$vence','$ncuotas','$cuotafija','$pagare','$valormora','$capitalmora')";
            $res = $this->_conn->query($query);
            return mysqli_insert_id($this->_conn->getConnection());
        }
    
        /**
         * update Recibe la informacion de un ahorros y aporte  y actualiza la informacion en la base de datos
         * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
         * @param  integer    identificador al cual se le va a realizar la actualizacion
         * @return void
         */
        
        public function vaciar(){
            $query = "truncate table saldos";
            $res = $this->_conn->query($query);
        }
    

}