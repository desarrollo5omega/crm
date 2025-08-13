<div style="padding: 40px; text-align: center; background: #333333;">
	<div style="display: inline-block; width:700px;">
		<table border="0" cellpadding="10" cellspacing="0" width="100%">
			<thead>
				<tr bgcolor="#FFFFFF">
					<td><img src="https://creditosfondtodos.com.co/skins/page/images/logo.png" height="100"></td>
					<td><h2 style="color:#000000;">Recuperacion de Contraseña</h2></td>
				</tr>
			</thead>
			<tr bgcolor="#269cd8">
				<td colspan="2" style="color: #FFFFFF; text-align: left;">
					<div><h2>Hola, <?php echo $this->nombre; ?></h2></div>
					<div>Usted recibi&oacute; este correo debido a que olvido su usuario o su contrase&ntilde;a .</div><br /><br />
					<div>Su usuarios es: <?php echo $this->usuario; ?> </div><br />
					<div>Haz clic en este link para cambiar su contrase&ntilde;a :</div><br />
					<div align="center"><a href="<?php echo $this->url; ?>" target="_blank" style="padding:10px; display:block; color:#FFFFFF; background:#76bc21; text-transform:uppercase; text-decoration:none;" >Restablecer Contrase&ntilde;a</a></div>
				</td>
			</tr>
		</table>
	</div>
</div>


