
<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5">
    <h2>Generar reportes</h2>
    <hr>
    <div class="row">
        
        <div class="col-md-4">
        <a href="#" class="btn btn-success">
            Reporte de Rankin de criminales mas buscados.
        </a>
        </div>
        <div class="col-md-4">
        <a href="#" class="btn btn-warning">
            Reporte de los meses donde se detectaron mas criminales.
        </a>
        </div>
        <div class="col-md-4">
        <a href="#" class="btn btn-primary">
            Reporte de los lugares por donde mas frecuentan los criminales
        </a>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>