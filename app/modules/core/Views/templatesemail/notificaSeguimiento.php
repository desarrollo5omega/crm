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
                        Le informamos que tiene seguimientos pendientes o vencidos en el sistema. A continuación encontrará el detalle correspondiente. Por favor, revise la información y tome las acciones necesarias.
                    </p>
                </div>
            </div>

            <div style="margin-top: 24px; font-family: Arial, sans-serif; font-size: 14px;">
                <table style="width: 100%; font-family: Arial, sans-serif; font-size: 14px; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 4px;"><strong>ID:</strong> <?php echo $this->id; ?></td>
                        <td style="padding: 4px;"><strong>Fecha:</strong> <?php echo $this->fecha; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 4px;"><strong>Seguimiento:</strong> <?php echo nl2br(htmlspecialchars($this->seguimiento)); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 4px;"><strong>Proyecto:</strong> <?php echo $this->proyecto; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: 4px;"><strong>Cliente:</strong> <?php echo $this->cliente; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;"><strong>Programado:</strong> <?php echo $this->programado ?: '-'; ?></td>
                        <td style="padding: 4px;"><strong>Finalizado:</strong> <?php echo $this->finalizado ?: 'No'; ?></td>
                    </tr>
                </table>
            </div>


        </div>
    </div>
</body>
</html>
