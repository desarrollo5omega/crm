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
                <div style="flex-grow: 1;width: 100%">
                    <p style="margin: 0; font-size: 16px; color: white;">
                        Se le ha sido asignado el siguiente proyecto:<strong style="color: white;"> <?= $this->proyecto ?></strong>.
                    </p>
                    <p style="margin: 0; font-size: 16px; color: white;">
                        Por favor ingrese al siguiente enlace y valide la solcitud.
                    </p>
                    <p style="margin: 10px; font-size: 16px; color: white;text-align: center;">
                        <button style="display: inline-block; padding: 0.375rem 0.75rem; font-size: 0.875rem; font-weight: 400; line-height: 1.5; text-align: center; text-decoration: none; white-space: nowrap; vertical-align: middle; cursor: pointer; border: 1px solid transparent; border-radius: 0.25rem; color: #fff; background-color: #77bc23; border-color: #77bc23;">
                            <a href="" target="_blank" style="text-decoration: none; color: white;">Ingrese aquí</a>
                        </button>
                    </p>
                </div>
            </div>
            <div style="margin-top: 24px;">
            </div>
        </div>
    </div>
</body>
</html>
