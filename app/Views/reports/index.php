<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 id="titulo">REPORTES</h3>
    </div>    

    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <a href="<?= base_url('reports/detecciones-por-zona'); ?>" class="btn btn-success btn-block rounded-pill shadow">
                <strong>Reporte de Detecciones por Zona</strong>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="<?= base_url('reports/alertas-generadas'); ?>" class="btn btn-warning btn-block rounded-pill shadow">
                <strong>Reporte de Alertas Generadas</strong>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="<?= base_url('reports/criminales-actualizados'); ?>" class="btn btn-primary btn-block rounded-pill shadow">
                <strong>Reporte de Criminales Actualizados</strong>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="<?= base_url('reports/rendimiento-sistema'); ?>" class="btn btn-info btn-block rounded-pill shadow">
                <strong>Reporte de Rendimiento del Sistema</strong>
            </a>
        </div>
        
    </div>
</div>

<?= $this->endSection(); ?>
