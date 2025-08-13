<?php

/**
 *
 */


class Page_reportesController extends Page_mainController
{
    public $botonpanel = 4;
    public function indexAction() {
        
        // return 
        $fecha_a = $this->_getSanitizedParam("fecha_a");
        $fecha_b = $this->_getSanitizedParam("fecha_b");
        $fecha_c = $this->_getSanitizedParam("fecha_c");
        $fecha_d = $this->_getSanitizedParam("fecha_d");

        $this->_view->fecha_a = $fecha_a;
        $this->_view->fecha_b = $fecha_b;
        $this->_view->fecha_c = $fecha_c;
        $this->_view->fecha_d = $fecha_d;


        $this->_view->mascotizan = $this->mascotizan();
        $this->_view->mascompran = $this->mascompran();
        $this->_view->meses = $this->get_meses();
        $this->_view->meses_completos = $this->get_meses_completos();
        $this->_view->num_clientes = $this->get_num_clientes();
        $this->_view->num_user = $this->get_num_user();


        $proyectosModel = new Page_Model_DbTable_Proyectos();
        $cotizaciones = $proyectosModel->getList(" estado NOT IN ('7','8','9') ", " fecha_c DESC ");

        $total_coti_aprobados = array();
        $total_coti_aprobados_num = array();
        $totales_coti = array();
        $totales_coti_valor = array();
        $cotizaciones_num = array();

        foreach ($cotizaciones as $coti) {
            $fecha = $coti->fecha_c;
            $aux = explode("-", $fecha);
            $ano = $aux[0];
            $mes_sin_cero = (int)$aux[1]; // Convertir a número para evitar ceros a la izquierda
            $mes_con_cero = $aux[1];

            // Asegurar que el índice existe antes de sumarlo
            if (!isset($total_coti_aprobados["$ano-$mes_sin_cero"])) {
                $total_coti_aprobados["$ano-$mes_sin_cero"] = 0;
            }
            if (!isset($totales_coti["$ano-$mes_sin_cero"])) {
                $totales_coti["$ano-$mes_sin_cero"] = 0;
            }

            $total_coti_aprobados["$ano-$mes_sin_cero"]++;
            $total_coti_aprobados_num["$ano-$mes_con_cero"]++;
            $totales_coti["$ano-$mes_sin_cero"] += $coti->valor;
            $totales_coti_valor["$ano-$mes_con_cero"] += $coti->valor;
            $cotizaciones_num["$ano"]++;
        }

        // Pasar los datos a la vista
        $this->_view->total_coti_aprobados = $total_coti_aprobados;
        $this->_view->total_coti_aprobados_num = $total_coti_aprobados_num;
        $this->_view->totales_coti = $totales_coti;
        $this->_view->totales_coti_valor = $totales_coti_valor;
        $this->_view->cotizaciones_num = $cotizaciones_num;

        $proyecto = $proyectosModel->getList(" estado = 6 ", " fecha_c DESC ");

        $total_proy_aprobados = array();
        $totales_proy = array();
        $array_proy_aprobados = array();

        foreach ($proyecto as $proy) {
            $fecha = $proy->fecha_c;
            $aux = explode("-", $fecha);
            $ano = $aux[0];
            $mes = (int)$aux[1]; // Convertir a número para evitar ceros a la izquierda

            // Asegurar que el índice existe antes de sumarlo
            if (!isset($total_proy_aprobados["$ano-$mes"])) {
                $total_proy_aprobados["$ano-$mes"] = 0;
            }
            if (!isset($totales_proy["$ano-$mes"])) {
                $totales_proy["$ano-$mes"] = 0;
            }

            $total_proy_aprobados["$ano-$mes"]++;
            $totales_proy["$ano-$mes"] += $proy->valor;
        }

        // Pasar los datos a la vista
        $this->_view->total_proy_aprobados = $total_proy_aprobados;
        $this->_view->totales_proy = $totales_proy;


        $anio = date("Y");
        $desarrollo = $proyectosModel->getList(" estado IN ('1', '7', '8') ", " fecha_c DESC ");

        $total_des_aprobados = array();
        $total_des_aprobados_valor = array();
        $totales_des = array();
        $desarrollo_num = array();

        foreach ($desarrollo as $des) {
            $fecha = $des->fecha_aprobado;
            $aux = explode("-", $fecha);
            $ano = $aux[0];
            $mes_sin_cero = (int)$aux[1]; // Convertir a número para evitar ceros a la izquierda
            $mes_con_cero = $aux[1];

            // Asegurar que el índice existe antes de sumarlo
            if (!isset($total_des_aprobados["$ano-$mes_sin_cero"])) {
                $total_des_aprobados["$ano-$mes_sin_cero"] = 0;
            }
            if (!isset($totales_des["$ano-$mes_sin_cero"])) {
                $totales_des["$ano-$mes_sin_cero"] = 0;
            }

            $total_des_aprobados["$ano-$mes_con_cero"]++;
            $totales_des["$ano-$mes_sin_cero"] += $des->valor;
            $total_des_aprobados_valor["$ano-$mes_con_cero"] += $des->valor;
            $desarrollo_num["$ano"]++;
        }

        // Pasar los datos a la vista
        $this->_view->total_des_aprobados = $total_des_aprobados;
        $this->_view->total_des_aprobados_valor = $total_des_aprobados_valor;
        $this->_view->totales_des = $totales_des;
        $this->_view->desarrollo_num = $desarrollo_num;

    }

    public function get_num_clientes()
    {
    
        $clientesModel = new Page_Model_DbTable_Clientes();
        $fecha = date("Y");
        $list = $clientesModel->getList("","");

        $cli = array();

        foreach ($list as $des) {
            $fecha = $des->fecha_c;
            $aux = explode("-", $fecha);
            $ano = $aux[0];
            $mes = (int)$aux[1];

            $cli["$ano-$mes"]++;
            $cli["$ano"]++;            
        }

        $cli["Total"] = count($list);

        return $cli;
    }

    public function get_num_user()
    {
    
        $usuarioModel = new Administracion_Model_DbTable_Usuario();
        $list = $usuarioModel->getList("","");

        $num = count($list);

        return $num;
    }

    public function mascotizan()
    {

        $fecha_a = $this->_getSanitizedParam("fecha_a");
        $fecha_b = $this->_getSanitizedParam("fecha_b");

        if (!$fecha_a) {
            $fecha_a = date('2023-m-01');
            $fecha_b = date('Y-m-d');
        }
    
        $proyectosModel = new Page_Model_DbTable_Proyectos();
        $cotizaciones = $proyectosModel->masCotizan(" p.fecha_c BETWEEN '".$fecha_a."' AND '".$fecha_b."' ");

        foreach ($cotizaciones as $key => $value) {
            $respuesta[$key] = $value; // Agregar cada valor sin sobrescribir
        }

        return $respuesta;
    }

    public function mascompran()
    {

        $fecha_a = $this->_getSanitizedParam("fecha_c");
        $fecha_b = $this->_getSanitizedParam("fecha_d");

        if (!$fecha_a) {
            $fecha_a = date('2023-m-01');
            $fecha_b = date('Y-m-d');
        }
    
        $proyectosModel = new Page_Model_DbTable_Proyectos();
        $cotizaciones = $proyectosModel->masCotizan(" p.fecha_c BETWEEN '".$fecha_a."' AND '".$fecha_b."' AND p.estado = '6' ");

        foreach ($cotizaciones as $key => $value) {
            $respuesta[$key] = $value; // Agregar cada valor sin sobrescribir
        }

        return $respuesta;
    }

    public function get_meses(){
        $array['01'] = "Ene";
        $array['02'] = "Feb";
        $array['03'] = "Mar";
        $array['04'] = "Abr";
        $array['05'] = "May";
        $array['06'] = "Jun";
        $array['07'] = "Jul";
        $array['08'] = "Ago";
        $array['09'] = "Sep";
        $array['10'] = "Oct";
        $array['11'] = "Nov";
        $array['12'] = "Dic";
        return $array;
    }

    public function get_meses_completos(){
        $array['01'] = "Enero";
        $array['02'] = "Febrero";
        $array['03'] = "Marzo";
        $array['04'] = "Abril";
        $array['05'] = "Mayo";
        $array['06'] = "Junio";
        $array['07'] = "Julio";
        $array['08'] = "Agosto";
        $array['09'] = "Septiembre";
        $array['10'] = "Octubre";
        $array['11'] = "Noviembre";
        $array['12'] = "Diciembre";
        return $array;
      }

    private function getEstado()
    {
		$array = array();
		$array['6'] = 'Pendiente';
		//$array['5'] = 'En cotización';
		$array['1'] = 'Aprobado';
		$array['2'] = 'No Aprobado';
		$array['3'] = 'En desarrollo';
		$array['4'] = 'Finalizado';
		return $array;
	} 

}