<<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <div class="d-flex justify-content-between align-items-center my-4">
        <h3 id="titulo">CAPTURA DETECTADA DEL CRIMINAL</h3>
    </div>

    <!-- Card para mostrar la foto de la detección -->
    <div class="card mx-auto shadow" style="width: 50%; border-radius: 15px; overflow: hidden;">
        <div class="card-body text-center">
            <!-- Título con el nombre del criminal si está disponible -->
            <?php if (isset($criminal['nombre'])): ?>
                <h4 class="card-title mb-4 text-dark font-weight-bold" style="letter-spacing: 1px; text-transform: uppercase;">
                    <?= esc($criminal['nombre']); ?>
                </h4>
            <?php endif; ?>

            <!-- Imagen de la detección -->
            <img src="<?= base_url('uploads/ImagenesCriminalesDetectados/' . esc($foto_deteccion)); ?>" 
                class="d-block w-100" alt="Foto de la detección" 
                style="max-height: 500px; object-fit: contain; border-radius: 10px;">

            <!-- Mostrar la fecha de detección si está disponible -->
            <?php if (isset($fecha_deteccion)): ?>
                <p class="text-muted small mt-3"><?= date('d-m-Y', strtotime($fecha_deteccion)); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
