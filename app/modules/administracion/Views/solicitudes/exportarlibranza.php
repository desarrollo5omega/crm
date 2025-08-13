<p> En cumplimiento de los artículos 55 y 56 de la Ley 1481 de 1989 y los artículos 149
                                    y 150 del código sustantivo de trabajo yo (nosotros)
                                    <strong><?php echo $this->nombre; ?><?php if($this->solicitud->tipo_garantia=="2"){ echo ", deudor(es) mayor (es) de
                                    edad ".$this->codeudor->nombres; } ?></strong>
                                    ,relacionado (s), identificado (s) y actuando en las condiciones como aparece
                                    en el encabezado de esta autorización de descuento, manifiesto (amos) que autorizo
                                    (amos) expresa e irrevocablemente al pagador de la empresa donde laboro (amos)
                                    actualmente o de la empresa donde llegare (mos) a laborar o prestar mis
                                    (nuestros)servicios, para que de mi (nuestros) salario (s), pensión (es),
                                    vacaciones, prestaciones, indemnizaciones, liquidaciones o cualquier otro emolumento
                                    que me (nos) corresponda por la prestación de mis (nuestros) servicios, así como a
                                    la EPS o ARL que cancele el citado el ingreso, descuente y cancele a favor del Fondo
                                    de Empleados FESDIS en forma indivisible, incondicional e ininterrumpida y hasta
                                    completar el monto total adeudado en capital e intereses. De igual forma, en caso de
                                    retiro de la empresa que determina el vínculo de asociación o cualquier otra empresa
                                    en la que llegare (mos) a prestar mis (nuestros) servicios antes de la cancelación
                                    total de la obligación, autorizo (amos) de manera voluntaria, expresa e
                                    irrevocablemente al pagador de la respectiva empresa, al fondo de cesantías al que
                                    esté (mos) vinculado (s) o la entidad correspondiente, para que descuente y retenga
                                    sin límite de cuantía sobre cualquier suma que deba pagárseme (nos) por concepto de
                                    salarios, honorarios, vacaciones, prestaciones sociales, bonificaciones especiales,
                                    ocasionales o permanentes, bonos y cualquier otro pago que perciba por otro concepto
                                    en virtud a la relación contractual y no estipulado literalmente, la cantidad que
                                    sea necesaria para cubrir el saldo insoluto de la (s) obligación(es) contraídas con
                                    el Fondo de Empleados FESDIS. En caso de respaldar crédito de vivienda bajo la línea
                                    específica las sumas de los descuentos aquí autorizados se deben entender como abono
                                    o prepago parcial disminuyendo el valor del plazo.


    </p>
    <p>Para estos efectos declaro (amos) suficiente la certificación del Fondo de Empleados FESDIS sobre el saldo
        debido a su favor. Las autorizaciones aquí plasmadas estarán vigentes mientras exista cualquier obligación
        nuestra a favor del Fondo de Empleados FESDIS.
    </p>
    <p></p>
<div>

    <table cellpadding="0" border="0" width="100%"  >
		<tr>
			<td style="width: 70;">
				<strong>Valor préstamo: </strong>
            </td>
            <td style="width: 80;text-align:center;">
                $<?php 
                echo number_format($_POST["prestamo"],2,",",".");?> <hr style="width: 80;">
            </td>
            <td style="width: 90px;">
            </td>
            <td style="width: 70px;">
				<strong> Línea de crédito: </strong>
            </td>
            <td style="width: 70px;text-align:center;">
				<?php echo $_POST["linea"]?> <hr style="width: 70px;">
            </td>
			</tr>
            <tr>
			<td style="width: 55px;">
				<strong>Valor Cuota: </strong>
            </td>
            <td style="width: 80;text-align:center;">
				$<?php echo  number_format($_POST["cuota"],2,",",".");?> <hr style="width: 80;">
            </td>
            <td style="width: 105px;">
            </td>   
            <td style="width: 70px;">
				<strong>Tasa de Interés : </strong>
            </td>
            <td style="width: 70px;text-align:center;">
           <?php echo  $_POST["tasa"];?> M.V.<hr style="width: 70px;">
            </td>
            </tr>		
            <tr>
			<td style="width: 80;">
				<strong>Número de Cuotas: </strong>
            </td>
            <td style="width: 70;text-align:center;">
				<?php echo $_POST["ncuotas"]?> <hr style="width: 70;">
            </td>
            <td style="width: 90px;">
            </td>
            <td style="width: 90px;">
				<strong>Código de descuento: </strong>
            </td>
            <td style="width: 70px;text-align:center;">
				<?php echo $_POST["codigo"]?> <hr style="width: 70px;">
            </td>
			</tr>
            </table>
<br>
<br>
            <table>
            <tr>
			<td style="width: 70;">
				Deudor principal: 
            </td>
            <td style="width: 180;text-align:center;">
				<?php echo $_POST["deudorp"]?> <hr style="width: 180px;">
            </td>
    
            </tr>
            <tr>
			<td style="width: 70;">
				Deudor Solidario: 
            </td>
            <td style="width: 180;text-align:center;">
				<?php echo $_POST["deudors"]?> <hr style="width: 180px;">
            </td>
    
            </tr>
            <tr>
			<td style="width: 205px;">FIRMA: Persona Autorizada de la empresa y/o pagador  
            </td>
            <td style="width: 150;text-align:center;">
				<span> </span><hr style="width: 150px;">
            </td>
    
            </tr>
            <tr>
			<td style="width: 30;">
				Fecha:
            </td>
            <td style="width: 80;text-align:center;">
				<?php echo $_POST["fecha"]?> <hr style="width: 80px;">
            </td>
    
            </tr>
            </table>
</div>

