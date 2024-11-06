<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Criminales Buscados Actualizados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .reporte-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .tabla-reporte {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .tabla-reporte thead {
            background-color: #0056b3;
            color: #fff;
        }
        .tabla-reporte th, .tabla-reporte td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .tabla-reporte tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .tabla-reporte tr:hover {
            background-color: #e1f5fe;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="reporte-container">
        <h1>REPORTE DE CRIMINALES BUSCADOS ACTUALIZADOS</h1>
        <table class="tabla-reporte">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Alias</th>
                    
                    <th>Razón de Búsqueda</th>
                    <th>Activo</th>
                    <th>Última Actualización</th>
                </tr>
            </thead>
            <tbody>
                <?php $num = 1; foreach ($criminales_actualizados as $criminal): ?>
                    <tr>
                        <td><?= $num++; ?></td>
                        <td><?= esc($criminal['nombre']); ?></td>
                        <td><?= esc($criminal['alias']); ?></td>
                        
                        <td><?= esc($criminal['razon_busqueda']); ?></td>
                        <td><?= esc($criminal['activo'] ? 'Sí' : 'No'); ?></td>
                        <td><?= esc($criminal['actualizado_en']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="footer">
            <p>Reporte generado automáticamente por el sistema de detección de criminales.</p>
            <p>&copy; <?= date("Y"); ?> SISPRO. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
