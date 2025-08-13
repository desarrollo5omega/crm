<div class="col-12">
  <form id="form1" name="form1" method="get" action="">
    <table border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td>
          <label for="fecha2d">Radicación (Inicio)</label>
          <br>
          <label>
            <input type="date" name="fecha1" id="fecha1" value="<?php echo $_GET['fecha1']; ?>" class="form-control" />
          </label>
        </td>
        <td>-</td>
        <td>
          <label for="fecha2d">Radicación (Final)</label>
          <br>
          <label>
            <input type="date" name="fecha2" id="fecha2" value="<?php echo $_GET['fecha2']; ?>" class="form-control" />
          </label>
        </td>
        <td>
          <label for="fecha2d">Desembolso (Inicio)</label>
          <br>
          <label>
            <input type="date" name="fecha1d" id="fecha1d" value="<?php echo $_GET['fecha1d']; ?>" class="form-control" />
          </label>
        </td>
        <td>-</td>
        <td>
          <label for="fecha2d">Desembolso (Final)</label>
          <br>
          <label>
            <input type="date" name="fecha2d" id="fecha2d" value="<?php echo $_GET['fecha2d']; ?>" class="form-control" />
          </label>
        </td>
        <td>
          
          <label>
            <input name="filtro" type="submit" class="btn btn-primary btn-sm" id="filtro" value="Filtrar" />
          </label>
        </td>
        <td>
          <a href="<?php echo explode("?",$_SERVER['REQUEST_URI'])[0]; ?>" class="enlace_verde">Limpiar</a>
        </td>
      </tr>
    </table>
  </form>
</div>