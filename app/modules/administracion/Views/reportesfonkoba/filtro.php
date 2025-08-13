<div class="col-12">
  <form id="form1" name="form1" method="get" action="">
    <table border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td>Rango de fechas</td>
        <td><label>
          <input type="date" name="fecha1" id="fecha1" value="<?php echo $_GET['fecha1']; ?>" />
        </label></td>
        <td>-</td>
        <td><label>
          <input type="date" name="fecha2" id="fecha2" value="<?php echo $_GET['fecha2']; ?>" />
        </label></td>
        <td><label>
          <input name="filtro" type="submit" class="btn btn-primary btn-sm" id="filtro" value="Filtrar" />
        </label></td>
        <td><a href="<?php echo explode("?",$_SERVER['REQUEST_URI'])[0]; ?>" class="enlace_verde">Limpiar</a></td>
      </tr>
    </table>
  </form>
</div>