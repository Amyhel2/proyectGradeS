<?= $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <hr>
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 id="titulo">REPORTES</h3>
    </div>    

    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <a href="<?= base_url('reports/generarReporteDeteccionesPorPeriodo'); ?>" class="btn btn-success btn-block rounded-pill shadow">
                <strong>Reporte de Detecciones por Periodo</strong>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="<?= base_url('reports/reporteCriminalesDetectados'); ?>" class="btn btn-warning btn-block rounded-pill shadow">
                <strong>Reporte de Criminales Detectados</strong>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="<?= base_url('reports/reporteActividadDeOficiales'); ?>" class="btn btn-primary btn-block rounded-pill shadow">
                <strong>Reporte de Actividad de Oficiales</strong>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="<?= base_url('reports/reporteCriminalesPorDelito'); ?>" class="btn btn-info btn-block rounded-pill shadow">
                <strong>Reporte de Criminales por Tipo de Delito</strong>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="<?= base_url('reports/reporteUbicacionesDeteccion'); ?>" class="btn btn-secondary btn-block rounded-pill shadow">
                <strong>Reporte de Ubicaciones de Detección</strong>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="<?= base_url('reports/reporteDeteccionesPorDispositivo'); ?>" class="btn btn-dark btn-block rounded-pill shadow">
                <strong>Reporte de Detecciones por Dispositivo</strong>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="<?= base_url('reports/reporteCriminalesActivosInactivos'); ?>" class="btn btn-light btn-block rounded-pill shadow">
                <strong>Reporte de Criminales Activos/Inactivos</strong>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="<?= base_url('reports/reporteCriminalesAltasConfianzas'); ?>" class="btn btn-primary btn-block rounded-pill shadow">
                <strong>Reporte de Criminales con Altas Confianzas</strong>
            </a>
        </div>
        
    </div>
</div>

<?= $this->endSection(); ?>
