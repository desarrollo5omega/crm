<?php

/**
 *
 */


class Page_dashController extends Page_mainController
{

    public function indexAction() {

        $proyectosModel =  new Page_Model_DbTable_Proyectos();
        
        $anio = date("Y");
        $cotizaciones = $proyectosModel->getList(" estado='6' AND fecha_c LIKE '$anio-%' "," fecha_c DESC ");

        $total_coti_aprobados = array();
        $totales_coti = array();
        foreach($cotizaciones as $coti){
            $fecha = $coti->fecha_c;
            $aux = explode("-",$fecha);
            $mes = $aux[1];
            $array_coti_aprobados[$mes][]=$coti;
            $total_coti_aprobados[$mes]++;
            $totales_coti[$mes] += $coti->valor;
        }

        $this->_view->array_coti_aprobados = $array_coti_aprobados;
        $this->_view->total_coti_aprobados = $total_coti_aprobados;
        $this->_view->totales_coti = $totales_coti;


        $proyectos_desarrollo = $proyectosModel->getList(" estado='1' AND fecha_aprobado LIKE '$anio-%' "," fecha_aprobado DESC ");

        $total_desarrollo = array();
        $totales = array();
        foreach($proyectos_desarrollo as $aprobados){
            $fecha = $aprobados->fecha_aprobado;
            $aux = explode("-",$fecha);
            $mes = $aux[1];
            $array_aprobados[$mes][]=$aprobados;
            $total_desarrollo[$mes]++;
            $totales[$mes] += $aprobados->valor;
        }

        $this->_view->array_aprobados = $array_aprobados;
        $this->_view->total_desarrollo = $total_desarrollo;
        $this->_view->totales = $totales;



        $lista = $proyectosModel->getList(" fecha_c LIKE '$anio-%' ", " fecha_c DESC ");

        $totalProyectos = 0; // Contador total de proyectos
        $estado = array(); // Para contar proyectos por estado
        $estadoSuma = array(); // Para sumar valores por estado
        $this->_view->listaestado = $this->getEstado();

        foreach ($lista as $proyectos) {
            $estadoProyecto = $proyectos->estado;

            // Inicializar los contadores por estado si no existen
            if (!isset($estado[$estadoProyecto])) {
                $estado[$estadoProyecto] = 0;
                $estadoSuma[$estadoProyecto] = 0; // Inicializa el suma para ese estado
            }

            // Contar proyectos por estado
            $estado[$estadoProyecto]++;

            // Sumar valores por estado
            $estadoSuma[$estadoProyecto] += $proyectos->valor; // Sumar valores por estado
        }

        // Calcular el total de proyectos
        $totalProyectos = array_sum($estado); // Total de proyectos

        // Preparar los datos para la vista
        $this->_view->totalProyectos = $totalProyectos; // Total de proyectos
        $this->_view->estado = $estado; // Conteo de estados
        $this->_view->estadoSuma = $estadoSuma; // Suma de valores por estado



        $this->_view->meses = $this->get_meses();
    }

    public function get_meses(){
        $array['01']="Enero";
        $array['02']="Febrero";
        $array['03']="Marzo";
        $array['04']="Abril";
        $array['05']="Mayo";
        $array['06']="Junio";
        $array['07']="Julio";
        $array['08']="Agosto";
        $array['09']="Septiembre";
        $array['10']="Octubre";
        $array['11']="Noviembre";
        $array['12']="Diciembre";
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