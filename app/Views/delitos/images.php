<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
<hr>
    <div class="d-flex justify-content-between align-items-center my-4">
        <h3 id="titulo" >GALERIA</h3>
    </div>

    <!-- Carrusel de fotos -->
    <div id="carouselFotos" class="carousel slide" data-ride="carousel">

        <!-- Indicadores numerados del carrusel -->
        <ol class="carousel-indicators">
            <?php foreach ($fotos as $index => $foto): ?>
                <li data-target="#carouselFotos" data-slide-to="<?= $index; ?>" class="<?= $index === 0 ? 'active' : ''; ?>"></li>
            <?php endforeach; ?>
        </ol>

        <div class="carousel-inner">
            <?php foreach ($fotos as $index => $foto): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                    <!-- Card contenedora con sombra suave -->
                    <div class="card mx-auto shadow" style="width: 50%; border-radius: 15px; overflow: hidden;">
                        <div class="card-body text-center">
                            <!-- Nombre del criminal centrado y con estilo minimalista -->
                            <h4 class="card-title mb-4 text-dark font-weight-bold" style="letter-spacing: 1px; text-transform: uppercase;">
    <?= esc($criminal['nombre']); ?>
</h4>

                            <!-- Imagen ajustada para no ser cortada -->
                            <img src="<?= base_url('uploads/criminales/' . $foto['ruta_foto']); ?>" 
                                class="d-block w-100" alt="Foto del criminal" 
                                style="max-height: 500px; object-fit: contain; border-radius: 10px;">
                            <!-- Fecha en un estilo más discreto -->
                            <p class="text-muted small mt-3"><?= date('d-m-Y', strtotime($foto['fecha_creacion'])); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Flechas de navegación -->
        <a class="carousel-control-prev" href="#carouselFotos" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#carouselFotos" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);"></span>
            <span class="sr-only">Siguiente</span>
        </a>

    </div>
</div>

<?= $this->endSection(); ?>

