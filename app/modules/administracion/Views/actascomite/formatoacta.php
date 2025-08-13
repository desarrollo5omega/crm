<?php
if($this->content->acta_tipo=="1"){
    $titulo = "COMIT&Eacute; ORDINARIO DE CR&Eacute;DITO";
}
if($this->content->acta_tipo=="3"){
    $titulo = "COMIT&Eacute; ESPECIAL DE CR&Eacute;DITO";
}
if($this->content->acta_tipo=="2"){
    $titulo = "PRESIDENCIA";
}
?>


<div class="container">
	<div class="row">

        <div class="col-12 text-end"><a href="/administracion/actascomite/formatoacta/?id=<?php echo $this->id; ?>&pdf=1" target="_blank"><button type="button" class="btn btn-primary">Exportar PDF</button></a> <a class="btn btn-success" href="/administracion/actascomite/">Regresar</a></div>

		<div class="col-12"><br></div>

		<table border="1" cellspacing="0" cellpadding="5" width="100%">
		  <tr>
		    <td width="170" rowspan="2" valign="top"><img src="https://creditosfondtodos.com.co/corte/logo1.png"></td>
		    <td width="322" rowspan="2"><p><strong><?php echo $titulo; ?></strong></p></td>
		    <td width="151"><p><strong>ACTA COC- <?php echo $this->content->acta_consecutivo; ?></strong></p></td>
		  </tr>
		  <tr>
		    <td width="151" valign="top"><p><strong>P&aacute;gina: 1 de 1</strong></p></td>
		  </tr>
		</table>

<?php
function convertirNumeroLetra($numero){
    $numf = miles($numero);
    return $numf;
}
function miles($nummero){
    if ($nummero >= 1000 && $nummero < 2000){
        $numm = "MIL ".(centena($nummero%1000));
    }
    if ($nummero >= 2000 && $nummero <10000){
        $numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
    }
    if ($nummero < 1000)
        $numm = centena($nummero);
    return $numm;
}
function centena($numc){
        if ($numc >= 100)
        {
            if ($numc >= 900 && $numc <= 999)
            {
                $numce = "NOVECIENTOS ";
                if ($numc > 900)
                    $numce = $numce.(decena($numc - 900));
            }
            else if ($numc >= 800 && $numc <= 899)
            {
                $numce = "OCHOCIENTOS ";
                if ($numc > 800)
                    $numce = $numce.(decena($numc - 800));
            }
            else if ($numc >= 700 && $numc <= 799)
            {
                $numce = "SETECIENTOS ";
                if ($numc > 700)
                    $numce = $numce.(decena($numc - 700));
            }
            else if ($numc >= 600 && $numc <= 699)
            {
                $numce = "SEISCIENTOS ";
                if ($numc > 600)
                    $numce = $numce.(decena($numc - 600));
            }
            else if ($numc >= 500 && $numc <= 599)
            {
                $numce = "QUINIENTOS ";
                if ($numc > 500)
                    $numce = $numce.(decena($numc - 500));
            }
            else if ($numc >= 400 && $numc <= 499)
            {
                $numce = "CUATROCIENTOS ";
                if ($numc > 400)
                    $numce = $numce.(decena($numc - 400));
            }
            else if ($numc >= 300 && $numc <= 399)
            {
                $numce = "TRESCIENTOS ";
                if ($numc > 300)
                    $numce = $numce.(decena($numc - 300));
            }
            else if ($numc >= 200 && $numc <= 299)
            {
                $numce = "DOSCIENTOS ";
                if ($numc > 200)
                    $numce = $numce.(decena($numc - 200));
            }
            else if ($numc >= 100 && $numc <= 199)
            {
                if ($numc == 100)
                    $numce = "CIEN ";
                else
                    $numce = "CIENTO ".(decena($numc - 100));
            }
        }
        else
            $numce = decena($numc);

        return $numce;
}
function decena($numdero){

        if ($numdero >= 90 && $numdero <= 99)
        {
            $numd = "NOVENTA ";
            if ($numdero > 90)
                $numd = $numd."Y ".(unidad($numdero - 90));
        }
        else if ($numdero >= 80 && $numdero <= 89)
        {
            $numd = "OCHENTA ";
            if ($numdero > 80)
                $numd = $numd."Y ".(unidad($numdero - 80));
        }
        else if ($numdero >= 70 && $numdero <= 79)
        {
            $numd = "SETENTA ";
            if ($numdero > 70)
                $numd = $numd."Y ".(unidad($numdero - 70));
        }
        else if ($numdero >= 60 && $numdero <= 69)
        {
            $numd = "SESENTA ";
            if ($numdero > 60)
                $numd = $numd."Y ".(unidad($numdero - 60));
        }
        else if ($numdero >= 50 && $numdero <= 59)
        {
            $numd = "CINCUENTA ";
            if ($numdero > 50)
                $numd = $numd."Y ".(unidad($numdero - 50));
        }
        else if ($numdero >= 40 && $numdero <= 49)
        {
            $numd = "CUARENTA ";
            if ($numdero > 40)
                $numd = $numd."Y ".(unidad($numdero - 40));
        }
        else if ($numdero >= 30 && $numdero <= 39)
        {
            $numd = "TREINTA ";
            if ($numdero > 30)
                $numd = $numd."Y ".(unidad($numdero - 30));
        }
        else if ($numdero >= 20 && $numdero <= 29)
        {
            if ($numdero == 20)
                $numd = "VEINTE ";
            else
                $numd = "VEINTI".(unidad($numdero - 20));
        }
        else if ($numdero >= 10 && $numdero <= 19)
        {
            switch ($numdero){
            case 10:
            {
                $numd = "DIEZ ";
                break;
            }
            case 11:
            {
                $numd = "ONCE ";
                break;
            }
            case 12:
            {
                $numd = "DOCE ";
                break;
            }
            case 13:
            {
                $numd = "TRECE ";
                break;
            }
            case 14:
            {
                $numd = "CATORCE ";
                break;
            }
            case 15:
            {
                $numd = "QUINCE ";
                break;
            }
            case 16:
            {
                $numd = "DIECISEIS ";
                break;
            }
            case 17:
            {
                $numd = "DIECISIETE ";
                break;
            }
            case 18:
            {
                $numd = "DIECIOCHO ";
                break;
            }
            case 19:
            {
                $numd = "DIECINUEVE ";
                break;
            }
            }   
        }
        else
            $numd = unidad($numdero);
    return $numd;
}

function unidad($numuero){
    switch ($numuero)
    {
        case 9:
        {
            $numu = "NUEVE";
            break;
        }
        case 8:
        {
            $numu = "OCHO";
            break;
        }
        case 7:
        {
            $numu = "SIETE";
            break;
        }       
        case 6:
        {
            $numu = "SEIS";
            break;
        }       
        case 5:
        {
            $numu = "CINCO";
            break;
        }       
        case 4:
        {
            $numu = "CUATRO";
            break;
        }       
        case 3:
        {
            $numu = "TRES";
            break;
        }       
        case 2:
        {
            $numu = "DOS";
            break;
        }       
        case 1:
        {
            $numu = "UN";
            break;
        }       
        case 0:
        {
            $numu = "";
            break;
        }
    }
    return $numu;
}

function fecha_letras($x){
	$aux=explode("-",$x);
	$meses = array('','enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
	$dias_letra = convertirNumeroLetra($aux[2]);
	$anio_letra = convertirNumeroLetra($aux[0]);
	$dias_letra = strtolower($dias_letra);
	$anio_letra = strtolower($anio_letra);

	$res = $dias_letra." (".$aux[2].") días del mes de ".$meses[$aux[1]*1]." del año ".$anio_letra." (".$aux[0].")";
	return $res;
}

$cabecera = $this->content->acta_cabecera;
$fecha_letras = fecha_letras($this->content->acta_fecha);


if($this->content->acta_tipo=="1"){
    $tipo_acta = "COMITÉ ORDINARIO DE CRÉDITO";
}
if($this->content->acta_tipo=="3"){
    $tipo_acta = "COMITÉ ESPECIAL DE CRÉDITO";
}
if($this->content->acta_tipo=="2"){
    $tipo_acta = "PRESIDENCIA";
}
$presidente = strtoupper(html_entity_decode($presidente));
$cabecera = str_replace("[FECHA]",$fecha_letras,$cabecera);
$tipo_acta = str_replace("[TIPO_ACTA]",$tipo_acta,$tipo_acta);

$cuerpo = $this->content->acta_cuerpo;
$presidente = $this->list_acta_presidente[$this->content->acta_presidente];
$presidente = strtoupper(html_entity_decode($presidente));
$secretaria = $this->list_acta_secretaria[$this->content->acta_secretaria];
$secretaria = strtoupper(html_entity_decode($secretaria));
$cuerpo = str_replace("[PRESIDENTE]",$presidente,$cuerpo);
$cuerpo = str_replace("[SECRETARIA]",$secretaria,$cuerpo);

?>

		<div class="col-12"><br></div>
		<div class="col-12"><?php echo $cabecera; ?></div>
		<div class="col-12">
			<table width="100%" border="0">
				<?php foreach ($this->asistentes as $key => $usuario): ?>
					<tr>
						<td><?php echo $usuario->user_names; ?></td>
						<td><?php echo $this->cargos[$usuario->user_level]; ?></td>
					</tr>
				<?php endforeach ?>
			</table><br>
		</div>
		<div class="col-12"><?php echo $cuerpo; ?></div>

		<div class="col-12"><br></div>

	</div>
</div>