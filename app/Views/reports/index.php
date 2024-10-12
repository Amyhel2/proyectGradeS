
<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 id="titulo">REPORTES</h3>
    </div>    

    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <a href="#" class="btn btn-success btn-block rounded-pill shadow">
                <strong>Reporte de Ranking de Criminales Más Buscados</strong>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="#" class="btn btn-warning btn-block rounded-pill shadow">
                <strong>Reporte de Meses con Más Detecciones de Criminales</strong>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="#" class="btn btn-primary btn-block rounded-pill shadow">
                <strong>Reporte de Lugares con Mayor Frecuencia de Criminales</strong>
            </a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>



