<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación Omega CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * {
            font-family: 'Roboto';
        }
    </style>
</head>
<?php
if ($this->agregar_valor == 1) {
    $tipo_name = "la cotización";
    $tipo_name2 = "de la cotización";
} else {
    $tipo_name = "el proyecto";
    $tipo_name2 = "del proyecto";
}
?>
<body style="font-family: Arial, sans-serif; background-color: #f0f4f8; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="background-color: #0d3a58; color: #ffffff; padding: 16px; display: flex; align-items: center;">
            <h4 style="margin: 0; font-size: 20px;">Notificaciones Omega CRM</h4>
        </div>
        <div style="padding: 24px;padding-top: 10px">
            <p style="font-size: 16px; margin-bottom: 24px;color: #0d3a58;">Cordial Saludo,</p>
            <div style="background-color: #0d3a58; padding: 16px; border-radius: 8px; display: flex; align-items: center;">
                <div style="flex-grow: 1;">
                    <p style="margin: 0; font-size: 16px; color: white;">
                        <strong style="color: white; text-transform: capitalize;"><?= $tipo_name ?>:</strong>
                        <?php echo $this->nombre; ?>, ha sido 
                        <strong style="color: white">NO APROBADO</strong>.
                    </p>
                </div>
            </div>
            <div style="margin-top: 24px;">
                <p style="margin: 0; font-size: 16px;">
                    <span style="color: #0d3a58;"> Cliente: </span> <strong> <?php echo $this->nombre_cliente; ?></strong>
                </p>
                <p style="margin: 0; font-size: 16px;">
                    <span style="color: #0d3a58;"> Fecha: </span> <strong> <?php echo $this->fecha_aprobado; ?></strong>
                </p>
                <?php if ($this->agregar_valor == 1) { ?>
                    <p style="margin: 0; font-size: 16px;">
                        <span style="color: #0d3a58;"> Valor <?= $tipo_name ?>: </span> <strong> $ <?php echo number_format($this->valor); ?></strong>
                    </p>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
