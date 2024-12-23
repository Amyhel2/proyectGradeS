<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <h3 id="titulo">NOTIFICACIONES</h3>

    <div class="table-responsive shadow-lg p-3 bg-body rounded">
        <table id="example1" class="table table-striped table-hover table-sm" aria-describedby="titulo">
            <thead class="bg-primary table-dark text-center">
                <tr>
                    <!--<th>ID Notificación</th>-->
                    <th>#</th>
                    <th>Oficial</th>
                    <th>Mensaje</th>
                    <th>Fecha Envío</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 $contador = 1;
                foreach($notificaciones as $notificacion): ?>
                <tr class="text-center">
                    <!--<td><?= $notificacion['idNotificacion']; ?></td>-->
                    <td><?= $contador++; ?></td>
                    <td><?= esc($notificacion['nombre_oficial']); ?></td>
                    <td><?= esc($notificacion['mensaje']); ?></td>
                    <td><?= esc($notificacion['fecha_envio']); ?></td>
                    <td><?= esc($notificacion['estado']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>

