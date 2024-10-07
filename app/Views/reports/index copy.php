
<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5">
    <h2>Reporte Detallado del Criminal Detectado</h2>
    <hr>
    <div class="row">
        
        <div class="col-md-8">
            <h3><?= esc($criminal['nombre']); ?> (Alias: <?= esc($criminal['alias']); ?>)</h3>
            <p><strong>CI:</strong> <?= esc($criminal['ci']); ?></p>
            <p><strong>Delitos:</strong> <?= esc($criminal['delitos']); ?></p>
            <p><strong>Razón de Búsqueda:</strong> <?= esc($criminal['razon_busqueda']); ?></p>
            <p><strong>Fecha de Detección:</strong> <?= esc($deteccion['fecha_deteccion']); ?></p>
            <p><strong>Ubicación:</strong> <?= esc($deteccion['ubicacion']); ?></p>
            <p><strong>Oficial:</strong> <?= esc($oficial['nombre']); ?></p>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>