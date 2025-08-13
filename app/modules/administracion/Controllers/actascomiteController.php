<?php
/**
* Controlador de Actascomite que permite la  creacion, edicion  y eliminacion de los actas comite del Sistema
*/
class Administracion_actascomiteController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos actas comite
	 * @var modeloContenidos
	 */
	public $mainModel;

	/**
	 * $route  url del controlador base
	 * @var string
	 */
	protected $route;

	/**
	 * $pages cantidad de registros a mostrar por pagina]
	 * @var integer
	 */
	protected $pages ;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "administracion_actascomite";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador actascomite .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Actascomite();
		$this->namefilter = "parametersfilteractascomite";
		$this->route = "/administracion/actascomite";
		$this->namepages ="pages_actascomite";
		$this->namepageactual ="page_actual_actascomite";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  actas comite con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Administración de actas comite";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "";
		$list = $this->mainModel->getList($filters,$order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page && Session::getInstance()->get($this->namepageactual)) {
		   	$page = Session::getInstance()->get($this->namepageactual);
		   	$start = ($page - 1) * $amount;
		} else if(!$page){
			$start = 0;
		   	$page=1;
			Session::getInstance()->set($this->namepageactual,$page);
		} else {
			Session::getInstance()->set($this->namepageactual,$page);
		   	$start = ($page - 1) * $amount;
		}
		$this->_view->register_number = count($list);
		$this->_view->pages = $this->pages;
		$this->_view->totalpages = ceil(count($list)/$amount);
		$this->_view->page = $page;
		$this->_view->lists = $lists = $this->mainModel->getListPages($filters,$order,$start,$amount);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->list_acta_tipo = $this->getActatipo();
		$this->_view->list_acta_presidente = $this->getActapresidente();
		$this->_view->list_acta_secretaria = $this->getActasecretaria();
		$this->_view->list_usuarios = $usuarios= $this->getUsuarios();

		foreach ($lists as $key => $value) {
			$asistentes = "";
			$ids = $value->acta_asistentes;
			$aux = explode(",",$ids);
			foreach ($aux as $key2 => $value2) {
				if($value2!=""){
					$asistentes.= $usuarios[$value2].", ";
				}
			}
			$asistentes = substr($asistentes, 0,-2);
			$value->asistentes = $asistentes;
		}
		$this->_view->lists = $lists;
	}

	public function formatoanexoAction()
	{
		$id = $this->_getSanitizedParam("id");
		$content = $this->mainModel->getById($id);
		$this->_view->content = $content;
		$this->_view->id = $id;

		$actascomiteitemsModel = new Administracion_Model_DbTable_Actascomiteitems();
		$solicitudModel = new Administracion_Model_DbTable_Solicitudes();
		$aportesModel = new Page_Model_DbTable_Aportes();
		$saldosModel = new Page_Model_DbTable_Saldos();
		$codeudorModel = new Administracion_Model_DbTable_Codeudor();
		$usuariosinfoModel = new Administracion_Model_DbTable_Usuariosinfo();
		$items = $actascomiteitemsModel->getList(" aci_acta_id='$id' ","");
		foreach ($items as $key => $value) {
			$solicitud_id = $value->aci_solicitud_id;
			$solicitud = $solicitudModel->getById($solicitud_id);
			$cedula = $solicitud->cedula;

			$aportes_list = $aportesModel->getList(" cedula='$cedula' "," id ASC ");
			$aportes = $aportes_list[0]->total_aportes;
			$smlv = 877803;
			$saldos_list = $saldosModel->getList("  estadocuenta_saldos_cedula='$cedula' ","");
			$saldos=0;
			foreach ($saldos_list as $key2 => $value2) {
				$saldos+=$value2->estadocuenta_saldos_stotal;
			}
			$cupo_max = (10*$aportes) - $saldos;
			if($cupo_max>150000000){ //tope supersolidaria
				$cupo_max = 150000000;
			}
			$solicitud->cupo_maximo = $cupo_max;
			$array = $this->getcupolinea($solicitud->linea_desembolso,$cedula,$aportes,$cupo_max);
			$solicitud->cupo_linea =  $array['cupo_actual'];
			$solicitud->saldo_recoger =  $array['saldos'];


			$codeudor = $codeudorModel->getList(" solicitud='$solicitud_id' AND codeudor_numero='1' ","")[0];
			$nombres_codeudor = $codeudor->nombres." ".$codeudor->nombres2." ".$codeudor->apellido1." ".$codeudor->apellido2;
			$codeudor2 = $codeudorModel->getList(" solicitud='$solicitud_id' AND codeudor_numero='2' ","")[0];
			$nombres_codeudor2 = $codeudor2->nombres." ".$codeudor2->nombres2." ".$codeudor2->apellido1." ".$codeudor2->apellido2;
			$solicitud->nombres_codeudor = $nombres_codeudor;
			$solicitud->nombres_codeudor2 = $nombres_codeudor2;
			$solicitud->datos_codeudor = $coudedor;
			$solicitud->datos_codeudor2 = $coudedor2;


			$salario = $solicitud->salario;
			$cedula = $solicitud->cedula;
			$usuariosinfo = $usuariosinfoModel->getList(" documento='$cedula' ")[0];
			if($salario==""){
				$solicitud->salario = $usuariosinfo->salario;
			}

			$value->solicitud = $solicitud;

		}
		$this->_view->items = $items;
		$this->_view->list_linea_desembolso = $list_linea_desembolso = $this->getLineadesembolso();


		$pdf = $this->_getSanitizedParam("pdf");
		if($pdf==1){
			$this->setLayout("blanco");
			$titulo = "FORMATO DE APROBACIÓN COMITÉ ORDINARIO";
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);
			$pdf->SetHeaderData('Logo.png', 30,$codigo,$titulo);
			$pdf->SetHeaderData('', 0,$codigo,'');
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setPrintFooter(false);

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(10);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			$pdf->AddPage('L', 'Legal');
			$pdf->SetFont('dejavusans', '',4, '', true);

			$tabla='';

			if($content->acta_tipo=="1"){
				$titulo_comite = "COMIT&Eacute; ORDINARIO DE CR&Eacute;DITO";
			}
			if($content->acta_tipo=="3"){
				$titulo_comite = "COMIT&Eacute; ESPECIAL DE CR&Eacute;DITO";
			}
			if($content->acta_tipo=="2"){
				$titulo_comite = "GERENCIA";
			}

			$tabla.='
				<table width="100%" cellpadding="3" cellspacing="0" border="0">
					<tr>
						<td height="70" colspan="7"><div><img src="http://fonkobacreditos.omegasolucionesweb.com/corte/logo1.png" height="50"></div></td>
					</tr>
					<tr>
						<td colspan="7">
							<div align="center"><b>
							'.$titulo_comite.'
							<br>
							RELACIÓN DE SOLICITUDES DE CRÉDITO</b>
							</div>
						</td>
					</tr>
				</table>
			';

			$tabla.='
				<table cellspacing="0" cellpadding="4" border="1" width="100%">

				  <tr height="48" bgcolor="#8EA9DB">
				    <td height="48" width="80">No.</td>
				    <td>No. Radicaci&oacute;n</td>
				    <td >Fecha Radicaci&oacute;n</td>
				    <td >N&uacute;mero Asignado</td>
				    <td >Nombre Asociado</td>
				    <td >N&uacute;mero Documento    de identificaci&oacute;n</td>
				    <td >Empresa</td>
				    <td >Modalidad</td>
				    <td >Cupo M&aacute;ximo</td>
				    <td >Cupo por l&iacute;nea</td>
				    <td >Valor Solicitud    de Cr&eacute;dito ($)</td>
				    <td >Plazo (Meses)</td>
				    <td >Valor Cuota ($)</td>
				    <td >Saldo Cart. a    Recoger Capital ($)</td>
				  </tr>';

				  foreach ($items as $key => $item){
				  	$solicitud = $item->solicitud;


					$tabla.='
						  <tr height="20">
						    <td height="20">'.($key+1).'</td>
						    <td>'.$solicitud->id.'</td>
						    <td>'.$solicitud->fecha_asignado.'</td>
						    <td>'.$solicitud->id.'</td>
						    <td>'.$solicitud->nombres.' '.$solicitud->nombres2.' '.$solicitud->apellido1.' '.$solicitud->apellido2.'</td>
						    <td>'.$solicitud->cedula.'</td>
						    <td>'.$solicitud->empresa.'</td>
						    <td>'.$list_linea_desembolso[$solicitud->linea_desembolso].'</td>
						    <td>$'.number_format($solicitud->cupo_maximo).'</td>
						    <td>$'.number_format($solicitud->cupo_linea).'</td>
						    <td>$'.number_format($solicitud->valor).'</td>
						    <td>'.($solicitud->cuotas).'</td>
						    <td>$'.number_format($solicitud->valor_cuota).'</td>
						    <td>$'.number_format($solicitud->valor_recogidos).'</td>
						  </tr>';
						  $totales['valor']+=$solicitud->valor;
				  }
			$tabla.='
				  <tr height="20" bgcolor="#8EA9DB">
				    <td height="20">&nbsp;</td>
				    <td >&nbsp;</td>
				    <td >&nbsp;</td>
				    <td >&nbsp;</td>
				    <td >&nbsp;</td>
				    <td >&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td >&nbsp;</td>
				    <td >&nbsp;</td>
				    <td >$'.number_format($totales['valor']).'</td>
				    <td >&nbsp;</td>
				    <td >&nbsp;</td>

				    <td >&nbsp;</td>
				  </tr>
				</table>

				<div class="col-12"><br></div>

				<table cellspacing="0" cellpadding="4" border="1" width="100%">

				  <tr height="48" bgcolor="#8EA9DB">
				    <td height="48" width="80">Salario    Mensual ($)</td>
				    <td >Tipo Salario</td>
				    <td >Nivel de    endeudamiento (Con Cuota Sol. Cr&eacute;d.)</td>
				    <td >Tipo Contrato</td>
				    <td >Neto Desembolso    ($)</td>
				    <td >Deudores    Solidarios&nbsp;</td>
				    <td >N&uacute;mero Asignado</td>
				    <td >N&uacute;mero Documento    de identificaci&oacute;n</td>
				    <td >Empresa</td>
				    <td >Salario Mensual ($)</td>
				    <td >Tipo Salario</td>
				    <td >Nivel de    endeudamiento (Con Cuota Sol. Cr&eacute;d.)</td>
				    <td >Tipo Contrato</td>
				    <td colspan="2" >Observaciones</td>
				  </tr>';

				$tipos = array("","OK APORTES","OK CODEUDOR","OK FONDO MUTUAL","OK HIPOTECA","OK PRENDA");
				
				foreach ($items as $key => $item){
					$solicitud = $item->solicitud;
					$salario = $solicitud->salario;
					$cedula = $solicitud->cedula;
					$usuariosinfo = $usuariosinfoModel->getList(" documento='$cedula' ")[0];
					if($salario==""){
						$salario = $usuariosinfo->salario;
					}

					$tabla.='
					  <tr height="20">
					    <td height="20">'.$salario.'</td>
					    <td>'.$solicitud->tipo_salario.'</td>
					    <td>'.$solicitud->capacidad_endeudamiento.'</td>
					    <td>&nbsp;</td>
					    <td>'.number_format($solicitud->valor_fm).'</td>
					    <td>'.number_format($solicitud->valor_desembolso).'</td>
					    <td>
					    	<div>'.$solicitud->nombres_codeudor.'</div>
					    </td>
					    <td>1</td>
					    <td>'.$solicitud->datos_codeudor->cedula.'</td>
					    <td>'.$solicitud->datos_codeudor->empresa.'</td>
					    <td>'.$solicitud->datos_codeudor->salario.'</td>
					    <td>'.$solicitud->datos_codeudor->tipo_salario.'</td>
					    <td>'.$solicitud->datos_codeudor->nivel_endeudamiento.'</td>
					    <td>'.$solicitud->datos_codeudor->tipo_contrato.'</td>
					    <td colspan="2">'.$tipos[$solicitud->tipo_garantia].'</td>
					  </tr>';
						if($solicitud->datos_codeudor2->cedula!=""){
							$tabla.='
						  <tr height="20">
					    	<td height="20">'.$salario.'</td>
					    	<td>'.$solicitud->tipo_salario.'</td>
						    <td>'.$solicitud->capacidad_endeudamiento.'</td>
						    <td>&nbsp;</td>
						    <td>'.number_format($solicitud->valor_fm).'</td>
						    <td>'.number_format($solicitud->valor_desembolso).'</td>
						    <td>
						    	<div>'.$solicitud->nombres_codeudor2.'</div>
						    </td>
						    <td>2</td>
						    <td>'.$solicitud->datos_codeudor2->cedula.'</td>
						    <td>'.$solicitud->datos_codeudor2->empresa.'</td>
						    <td>'.$solicitud->datos_codeudor2->salario.'</td>
						    <td>'.$solicitud->datos_codeudor2->tipo_salario.'</td>
						    <td>'.$solicitud->datos_codeudor2->nivel_endeudamiento.'</td>
						    <td>'.$solicitud->datos_codeudor2->tipo_contrato.'</td>
						    <td colspan="2">'.$tipos[$solicitud->tipo_garantia].'</td>
						  </tr>';
						}
				}
				$tabla.='
				  <tr height="20" bgcolor="#8EA9DB">
				    <td height="20">&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td colspan="2" >&nbsp;</td>
				  </tr>
				</table>
			';

			$tabla = html_entity_decode($tabla);

			if(1==1){
				$pdf->writeHTMLCell(0, 0, '', '', $tabla, 0, 1, 0, true, '', true);
				$pdf->Output('reporte.pdf', 'I');
			}else{
				echo $tabla;
			}
		}

	}

	public function getcupolinea($linea,$cedula,$aportes,$cupo_max){
		$saldosModel = new Page_Model_DbTable_Saldos();
		$smlv = 877803;
		$ahorros = 0;
		//echo "LINEA".$linea."-CEDULA:".$cedula."-APORTES:".$aportes."<br>";

		if($linea=="CS"){
			$saldos_list = $saldosModel->getList(" (estadocuenta_saldos_linea LIKE '%SOCIAL%') AND estadocuenta_saldos_cedula='$cedula' ","");
			$saldos=0;
			foreach ($saldos_list as $key => $value) {
				$saldos+=$value->estadocuenta_saldos_stotal;
			}
			$cupo_actual = $smlv*25;
			$cupo_actual = $cupo_actual - $saldos;
			if($cupo_actual > $cupo_max){
				$cupo_actual = $cupo_max;
			}
		}
		if($linea=="CE"){
			$saldos_list = $saldosModel->getList(" (estadocuenta_saldos_linea LIKE '%EDUCACION%') AND estadocuenta_saldos_cedula='$cedula' ","");
			$saldos=0;
			foreach ($saldos_list as $key => $value) {
				$saldos+=$value->estadocuenta_saldos_stotal;
			}
			$cupo_actual = $smlv*20;
			$max = 6*($aportes+$ahorros);
			if($cupo_actual > $max){
				$cupo_actual = $max;
			}
			$cupo_actual = $cupo_actual - $saldos;
			if($cupo_actual > $cupo_max){
				$cupo_actual = $cupo_max;
			}
		}
		if($linea=="CVV"){
			$saldos_list = $saldosModel->getList(" estadocuenta_saldos_linea LIKE '%VIVIENDA%' AND estadocuenta_saldos_cedula='$cedula' ","");
			$saldos=0;
			foreach ($saldos_list as $key => $value) {
				$saldos+=$value->estadocuenta_saldos_stotal;
			}
			$cupo_actual = (20*$aportes) + (5*$ahorros);
			$max = $smlv*150;
			if($cupo_actual > $max){
				$cupo_actual = $max;
			}
			$cupo_actual = $cupo_actual - $saldos;
			if($cupo_actual > $cupo_max){
				//$cupo_actual = $cupo_max;
			}

		}
		if($linea=="CVH"){
			$saldos_list = $saldosModel->getList(" estadocuenta_saldos_linea LIKE '%VEHICULO%' AND estadocuenta_saldos_cedula='$cedula' ","");
			$saldos=0;
			foreach ($saldos_list as $key => $value) {
				$saldos+=$value->estadocuenta_saldos_stotal;
			}
			$cupo_actual = (10*$aportes) + (3*$ahorros);
			$max = $smlv*80;
			if($cupo_actual > $max){
				$cupo_actual = $max;
			}
			$cupo_actual = $cupo_actual - $saldos;
			if($cupo_actual > $cupo_max){
				$cupo_actual = $cupo_max;
			}

		}
		if($linea=="CM"){
			$saldos_list = $saldosModel->getList(" (estadocuenta_saldos_linea LIKE '%MULTIPROPOSITO%' ) AND estadocuenta_saldos_cedula='$cedula' ","");
			$saldos=0;
			foreach ($saldos_list as $key => $value) {
				$saldos+=$value->estadocuenta_saldos_stotal;
			}
			$cupo_actual = (7*$aportes) + (2*$ahorros);
			$max = $smlv*70;
			if($cupo_actual > $max){
				$cupo_actual = $max;
			}
			$cupo_actual = $cupo_actual - $saldos;
			if($cupo_actual > $cupo_max){
				$cupo_actual = $cupo_max;
			}
		}

		if($linea=="CF"){
			$saldos_list = $saldosModel->getList(" estadocuenta_saldos_linea LIKE '%CREDIFACIL%' AND estadocuenta_saldos_linea!='CREDIFACIL CUOTA UNICA' AND estadocuenta_saldos_cedula='$cedula' ","");
			$saldos=0;
			foreach ($saldos_list as $key => $value) {
				$saldos+=$value->estadocuenta_saldos_stotal;
			}
			$cupo_actual = (6*$aportes) + (2*$ahorros);
			$max = $smlv*4;
			if($cupo_actual > $max){
				$cupo_actual = $max;
			}
			$cupo_actual = $cupo_actual - $saldos;
			if($cupo_actual > $cupo_max){
				$cupo_actual = $cupo_max;
			}
		}
		if($linea=="CFS"){
			$saldos_list = $saldosModel->getList(" estadocuenta_saldos_linea = 'SERVICIOS FINANCIADOS' AND estadocuenta_saldos_cedula='$cedula' ","");
			$saldos=0;
			foreach ($saldos_list as $key => $value) {
				$saldos+=$value->estadocuenta_saldos_stotal;
			}
			$cupo_actual = (10*$aportes) + (3*$ahorros);
			$max = $smlv*10;
			if($cupo_actual > $max){
				$cupo_actual = $max;
			}
			$cupo_actual = $cupo_actual - $saldos;
			if($cupo_actual > $cupo_max){
				$cupo_actual = $cupo_max;
			}
		}
		if($linea=="CCC"){
			$saldos_list = $saldosModel->getList(" ( estadocuenta_saldos_linea LIKE '%COMPRA CARTERA%' ) AND estadocuenta_saldos_cedula='$cedula' ","");
			$saldos=0;
			foreach ($saldos_list as $key => $value) {
				$saldos+=$value->estadocuenta_saldos_stotal;
			}
			$cupo_actual = (8*$aportes) + (3*$ahorros);
			$max = $smlv*70;
			if($cupo_actual > $max){
				$cupo_actual = $max;
			}
			$cupo_actual = $cupo_actual - $saldos;
			if($cupo_actual > $cupo_max){
				$cupo_actual = $cupo_max;
			}
		}
		if($linea=="CFU"){
			$saldos_list = $saldosModel->getList(" estadocuenta_saldos_linea = 'CREDIFACIL CUOTA UNICA' AND estadocuenta_saldos_cedula='$cedula' ","");
			$saldos=0;
			foreach ($saldos_list as $key => $value) {
				$saldos+=$value->estadocuenta_saldos_stotal;
			}
			$cupo_actual = ($salario/2);
			$cupo_actual = $smlv*10;
			$cupo_actual = $cupo_actual - $saldos;
			if($cupo_actual > $cupo_max){
				$cupo_actual = $cupo_max;
			}
		}

		$data['cupo_actual'] = $cupo_actual;
		$data['saldos'] = $saldos;
		return $data;

	}

	public function getLineadesembolso()
	{
		$array = array();
		$lineaModel = new Administracion_Model_DbTable_Lineas();
		$list = $lineaModel->getList(" activo='1' "," nombre ASC ");
		foreach ($list as $key => $value) {
			$array[$value->codigo] = $value->nombre;
		}
		return $array;
	}

	public function formatoactaAction()
	{
		$id = $this->_getSanitizedParam("id");
		$content = $this->mainModel->getById($id);
		$this->_view->content = $content;
		$this->_view->id = $id;

		$asistentes = array();
		$ids = $content->acta_asistentes;
		$aux = explode(",",$ids);
		foreach ($aux as $key2 => $user_id) {
			if($user_id>0){
				$usuariosModel = new Administracion_Model_DbTable_Usuario();
				$usuario = $usuariosModel->getById($user_id);
				$asistentes[]=$usuario;
			}
		}
		$this->_view->asistentes = $asistentes;

		$array = array();
		$array['1'] = 'Administrador';
		$array['3'] = 'Analista';
		$array['4'] = 'Miembro del Comité Ordinario de Crédito';
		$array['8'] = 'Gerente';
		$array['9'] = 'Miembro del Comité Especial de Crédito';
		$this->_view->cargos = $cargos = $array;

		$this->_view->list_acta_presidente = $list_acta_presidente =  $this->getActapresidente();
		$this->_view->list_acta_secretaria = $list_acta_secretaria = $this->getActasecretaria();



		$pdf = $this->_getSanitizedParam("pdf");
		if($pdf==1){
			$this->setLayout("blanco");
			$titulo = "FORMATO DE ACTA";
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);
			$pdf->SetHeaderData('Logo.png', 30,$codigo,$titulo);
			$pdf->SetHeaderData('', 0,$codigo,'');
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setPrintFooter(false);

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(10);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			$pdf->AddPage('P', 'A4');
			$pdf->SetFont('dejavusans', '',8, '', true);

			if($content->acta_tipo=="1"){
			    $tipo_acta = "COMITÉ ORDINARIO DE CRÉDITO";
			}
			if($content->acta_tipo=="3"){
			    $tipo_acta = "COMITÉ ESPECIAL DE CRÉDITO";
			}
			if($content->acta_tipo=="2"){
			    $tipo_acta = "PRESIDENCIA";
			}

			$tabla = '';
			$tabla.='
				<table border="1" cellspacing="0" cellpadding="5" width="100%">
				  <tr>
				    <td rowspan="2" valign="top"><img src="https://creditosfondtodos.com.co/corte/logo1.png" height="70"></td>
				    <td  rowspan="2"><p><strong>'.$tipo_acta.'</strong></p></td>
				    <td ><p><strong>ACTA COC- '.$content->acta_consecutivo.'</strong></p></td>
				  </tr>
				  <tr>
				    <td valign="top"><p><strong>Página: 1 de 1</strong></p></td>
				  </tr>
				</table>
			';



			$cabecera = $content->acta_cabecera;
			$fecha_letras = $this->fecha_letras($content->acta_fecha);
			$cabecera = str_replace("[FECHA]",$fecha_letras,$cabecera);
			$cabecera = str_replace("[TIPO_ACTA]",$tipo_acta,$cabecera);

			$cuerpo = $content->acta_cuerpo;
			$presidente = $list_acta_presidente[$content->acta_presidente];
			$presidente = strtoupper(html_entity_decode($presidente));
			$secretaria = $list_acta_secretaria[$content->acta_secretaria];
			$secretaria = strtoupper(html_entity_decode($secretaria));
			$cuerpo = str_replace("[PRESIDENTE]",$presidente,$cuerpo);
			$cuerpo = str_replace("[SECRETARIA]",$secretaria,$cuerpo);


			$tabla.='
				<div class="col-12"><br></div>
				<div class="col-12">'.$cabecera.'</div>
				<div class="col-12">
					<table width="100%" border="0">';

						foreach ($asistentes as $key => $usuario){
							$tabla.='<tr>
								<td>'.$usuario->user_names.'</td>
								<td>'.$cargos[$usuario->user_level].'</td>
							</tr>';
						}
			$tabla.='
					</table><br>
				</div>
				<div class="col-12">'.$cuerpo.'</div>

				<div class="col-12"><br></div>
			';

			$tabla = html_entity_decode($tabla);

			if(1==1){
				$pdf->writeHTMLCell(0, 0, '', '', $tabla, 0, 1, 0, true, '', true);
				$pdf->Output('reporte.pdf', 'I');
			}else{
				echo $tabla;
			}

		}

	}

	/**
     * Genera la Informacion necesaria para editar o crear un  acta comite  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_actascomite_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$this->_view->list_acta_tipo = $this->getActatipo();
		$this->_view->list_acta_presidente = $this->getActapresidente();
		$this->_view->list_acta_secretaria = $this->getActasecretaria();
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->acta_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar acta comite";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear acta comite";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear acta comite";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
		$this->_view->list_usuarios = $this->getUsuarios();
	}

	/**
     * Inserta la informacion de un acta comite  y redirecciona al listado de actas comite.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['acta_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR ACTA COMITE';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un acta comite  y redirecciona al listado de actas comite.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->acta_id) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['acta_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR ACTA COMITE';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un acta comite  y redirecciona al listado de actas comite.
     *
     * @return void.
     */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf ) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR ACTA COMITE';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	public function agregarAction(){
		$actascomiteitemsModel = new Administracion_Model_DbTable_Actascomiteitems();
		$aci_acta_id = $data['aci_acta_id'] = $this->_getSanitizedParam("acta");
		$aci_solicitud_id = $data['aci_solicitud_id'] = $this->_getSanitizedParam("id");
		$aci_fecha = $data['aci_fecha'] = date("Y-m-d H:i:s");
		$actascomiteitemsModel->insert($data);
		header("Location: /administracion/solicitudes/agregarcreditos/?id=".$aci_acta_id);
	}

	public function quitarAction(){
		$actascomiteitemsModel = new Administracion_Model_DbTable_Actascomiteitems();
		$aci_acta_id = $data['aci_acta_id'] = $this->_getSanitizedParam("acta");
		$aci_solicitud_id = $data['aci_solicitud_id'] = $this->_getSanitizedParam("id");
		$aci_fecha = $data['aci_fecha'] = date("Y-m-d H:i:s");
		$aci_id = $actascomiteitemsModel->getList(" aci_acta_id='$aci_acta_id' AND aci_solicitud_id='$aci_solicitud_id' ","")[0]->aci_id;
		$actascomiteitemsModel->deleteRegister($aci_id);
		header("Location: /administracion/solicitudes/agregarcreditos/?id=".$aci_acta_id);
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Actascomite.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['acta_fecha'] = $this->_getSanitizedParam("acta_fecha");
		$data['acta_tipo'] = $this->_getSanitizedParam("acta_tipo");
		$data['acta_asistentes'] = $this->_getSanitizedParam("acta_asistentes");
		$data['acta_presidente'] = $this->_getSanitizedParam("acta_presidente");
		$data['acta_secretaria'] = $this->_getSanitizedParam("acta_secretaria");
		$data['acta_cabecera'] = $this->_getSanitizedParamHtml("acta_cabecera");
		$data['acta_cuerpo'] = $this->_getSanitizedParamHtml("acta_cuerpo");
		$data['acta_consecutivo'] = $this->_getSanitizedParamHtml("acta_consecutivo");
		return $data;
	}

	/**
     * Genera los valores del campo acta_tipo.
     *
     * @return array cadena con los valores del campo acta_tipo.
     */
	private function getActatipo()
	{
		$array = array();
		$array['1'] = 'Comité ordinario';
		$array['3'] = 'Comité especial';
		$array['2'] = 'Presidencia';
		return $array;
	}



	/**
     * Genera los valores del campo acta_presidente.
     *
     * @return array cadena con los valores del campo acta_presidente.
     */
	private function getActapresidente()
	{
		$array = array();
		$usuariosModel = new Administracion_Model_DbTable_Usuario();
		$usuarios = $usuariosModel->getList(""," user_names ASC ");
		foreach ($usuarios as $key => $value) {
			$array[$value->user_id] = $value->user_names;
		}
		return $array;
	}

	private function getUsuarios()
	{
		$array = array();
		$usuariosModel = new Administracion_Model_DbTable_Usuario();
		$usuarios = $usuariosModel->getList(""," user_names ASC ");
		foreach ($usuarios as $key => $value) {
			$array[$value->user_id] = $value->user_names;
		}
		return $array;
	}


	/**
     * Genera los valores del campo acta_secretaria.
     *
     * @return array cadena con los valores del campo acta_secretaria.
     */
	private function getActasecretaria()
	{
		$array = array();
		$usuariosModel = new Administracion_Model_DbTable_Usuario();
		$usuarios = $usuariosModel->getList(""," user_names ASC ");
		foreach ($usuarios as $key => $value) {
			$array[$value->user_id] = $value->user_names;
		}
		return $array;
	}

	/**
     * Genera la consulta con los filtros de este controlador.
     *
     * @return array cadena con los filtros que se van a asignar a la base de datos
     */
    protected function getFilter()
    {
    	$filtros = " 1 = 1 ";
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->acta_fecha != '') {
                $filtros = $filtros." AND acta_fecha LIKE '%".$filters->acta_fecha."%'";
            }
            if ($filters->acta_tipo != '') {
                $filtros = $filtros." AND acta_tipo ='".$filters->acta_tipo."'";
            }
            if ($filters->acta_asistentes != '') {
                $filtros = $filtros." AND acta_asistentes LIKE '%".$filters->acta_asistentes."%'";
            }
            if ($filters->acta_presidente != '') {
                $filtros = $filtros." AND acta_presidente ='".$filters->acta_presidente."'";
            }
            if ($filters->acta_secretaria != '') {
                $filtros = $filtros." AND acta_secretaria ='".$filters->acta_secretaria."'";
            }
            if ($filters->acta_cabecera != '') {
                $filtros = $filtros." AND acta_cabecera LIKE '%".$filters->acta_cabecera."%'";
            }
            if ($filters->acta_cuerpo != '') {
                $filtros = $filtros." AND acta_cuerpo LIKE '%".$filters->acta_cuerpo."%'";
            }
            if ($filters->acta_consecutivo != '') {
                $filtros = $filtros." AND acta_consecutivo LIKE '%".$filters->acta_consecutivo."%'";
            }
		}
        return $filtros;
    }

    /**
     * Recibe y asigna los filtros de este controlador
     *
     * @return void
     */
    protected function filters()
    {
        if ($this->getRequest()->isPost()== true) {
        	Session::getInstance()->set($this->namepageactual,1);
            $parramsfilter = array();
					$parramsfilter['acta_fecha'] =  $this->_getSanitizedParam("acta_fecha");
					$parramsfilter['acta_tipo'] =  $this->_getSanitizedParam("acta_tipo");
					$parramsfilter['acta_asistentes'] =  $this->_getSanitizedParam("acta_asistentes");
					$parramsfilter['acta_presidente'] =  $this->_getSanitizedParam("acta_presidente");
					$parramsfilter['acta_secretaria'] =  $this->_getSanitizedParam("acta_secretaria");
					$parramsfilter['acta_cabecera'] =  $this->_getSanitizedParam("acta_cabecera");
					$parramsfilter['acta_cuerpo'] =  $this->_getSanitizedParam("acta_cuerpo");
					$parramsfilter['acta_consecutivo'] =  $this->_getSanitizedParam("acta_consecutivo");
					Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }



	public function convertirNumeroLetra($numero){
	    $numf = $this->miles($numero);
	    return $numf;
	}
	public function miles($nummero){
	    if ($nummero >= 1000 && $nummero < 2000){
	        $numm = "MIL ".($this->centena($nummero%1000));
	    }
	    if ($nummero >= 2000 && $nummero <10000){
	        $numm = $this->unidad(Floor($nummero/1000))." MIL ".($this->centena($nummero%1000));
	    }
	    if ($nummero < 1000)
	        $numm = $this->centena($nummero);
	    return $numm;
	}
	public function centena($numc){
	        if ($numc >= 100)
	        {
	            if ($numc >= 900 && $numc <= 999)
	            {
	                $numce = "NOVECIENTOS ";
	                if ($numc > 900)
	                    $numce = $numce.($this->decena($numc - 900));
	            }
	            else if ($numc >= 800 && $numc <= 899)
	            {
	                $numce = "OCHOCIENTOS ";
	                if ($numc > 800)
	                    $numce = $numce.($this->decena($numc - 800));
	            }
	            else if ($numc >= 700 && $numc <= 799)
	            {
	                $numce = "SETECIENTOS ";
	                if ($numc > 700)
	                    $numce = $numce.($this->decena($numc - 700));
	            }
	            else if ($numc >= 600 && $numc <= 699)
	            {
	                $numce = "SEISCIENTOS ";
	                if ($numc > 600)
	                    $numce = $numce.($this->decena($numc - 600));
	            }
	            else if ($numc >= 500 && $numc <= 599)
	            {
	                $numce = "QUINIENTOS ";
	                if ($numc > 500)
	                    $numce = $numce.($this->decena($numc - 500));
	            }
	            else if ($numc >= 400 && $numc <= 499)
	            {
	                $numce = "CUATROCIENTOS ";
	                if ($numc > 400)
	                    $numce = $numce.($this->decena($numc - 400));
	            }
	            else if ($numc >= 300 && $numc <= 399)
	            {
	                $numce = "TRESCIENTOS ";
	                if ($numc > 300)
	                    $numce = $numce.($this->decena($numc - 300));
	            }
	            else if ($numc >= 200 && $numc <= 299)
	            {
	                $numce = "DOSCIENTOS ";
	                if ($numc > 200)
	                    $numce = $numce.($this->decena($numc - 200));
	            }
	            else if ($numc >= 100 && $numc <= 199)
	            {
	                if ($numc == 100)
	                    $numce = "CIEN ";
	                else
	                    $numce = "CIENTO ".($this->decena($numc - 100));
	            }
	        }
	        else
	            $numce = $this->decena($numc);

	        return $numce;
	}
	public function decena($numdero){

	        if ($numdero >= 90 && $numdero <= 99)
	        {
	            $numd = "NOVENTA ";
	            if ($numdero > 90)
	                $numd = $numd."Y ".($this->unidad($numdero - 90));
	        }
	        else if ($numdero >= 80 && $numdero <= 89)
	        {
	            $numd = "OCHENTA ";
	            if ($numdero > 80)
	                $numd = $numd."Y ".($this->unidad($numdero - 80));
	        }
	        else if ($numdero >= 70 && $numdero <= 79)
	        {
	            $numd = "SETENTA ";
	            if ($numdero > 70)
	                $numd = $numd."Y ".($this->unidad($numdero - 70));
	        }
	        else if ($numdero >= 60 && $numdero <= 69)
	        {
	            $numd = "SESENTA ";
	            if ($numdero > 60)
	                $numd = $numd."Y ".($this->unidad($numdero - 60));
	        }
	        else if ($numdero >= 50 && $numdero <= 59)
	        {
	            $numd = "CINCUENTA ";
	            if ($numdero > 50)
	                $numd = $numd."Y ".($this->unidad($numdero - 50));
	        }
	        else if ($numdero >= 40 && $numdero <= 49)
	        {
	            $numd = "CUARENTA ";
	            if ($numdero > 40)
	                $numd = $numd."Y ".($this->unidad($numdero - 40));
	        }
	        else if ($numdero >= 30 && $numdero <= 39)
	        {
	            $numd = "TREINTA ";
	            if ($numdero > 30)
	                $numd = $numd."Y ".($this->unidad($numdero - 30));
	        }
	        else if ($numdero >= 20 && $numdero <= 29)
	        {
	            if ($numdero == 20)
	                $numd = "VEINTE ";
	            else
	                $numd = "VEINTI".($this->unidad($numdero - 20));
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
	            $numd = $this->unidad($numdero);
	    return $numd;
	}

	public function unidad($numuero){
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

	public function fecha_letras($x){
		$aux=explode("-",$x);
		$meses = array('','enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
		$dias_letra = $this->convertirNumeroLetra($aux[2]);
		$anio_letra = $this->convertirNumeroLetra($aux[0]);
		$dias_letra = strtolower($dias_letra);
		$anio_letra = strtolower($anio_letra);

		$res = $dias_letra." (".$aux[2].") días del mes de ".$meses[$aux[1]*1]." del año ".$anio_letra." (".$aux[0].")";
		return $res;
	}

}