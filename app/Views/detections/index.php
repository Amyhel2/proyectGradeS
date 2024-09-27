<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <h3 id="titulo">DETECCIONES</h3>

    <div class="table-responsive shadow-lg p-3 bg-body rounded">
        <table id="example2" class="table table-striped table-hover table-sm" aria-describedby="titulo">
            <thead class="bg-info table-dark text-center">
                <tr>
                    <th>ID Detección</th>
                    <th>Criminal</th>
                    <th>Oficial</th>
                    <th>Fecha Detección</th>
                    <th>Ubicación</th>
                    <th>Nivel de Confianza</th>
                </tr>
            </thead>
            <tbody>
    <?php foreach($detecciones as $deteccion): ?>
    <tr class="text-center">
        <td><?= esc($deteccion['idDeteccion']); ?></td>
        <td><?= esc($deteccion['criminal_nombre']); ?></td> <!-- Muestra el nombre del criminal -->
        <td><?= esc($deteccion['oficial_id']); ?></td>
        <td><?= esc($deteccion['fecha_deteccion']); ?></td>
        <td><?= esc($deteccion['ubicacion']); ?></td>
        <td><?= esc($deteccion['confianza']); ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
 
        </table>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>



<?= $this->endSection(); ?>
