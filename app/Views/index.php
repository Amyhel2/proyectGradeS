<?php echo $this->extend('layout/templateStart'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm bg-secondary">
                <div class="card-body text-center">
                    <h1 class="display-4">Bienvenido al sistema</h1>
                    <p class="lead">Estamos encantados de verte aquí.</p>
                    <a href="<?= base_url('logout'); ?>" class="btn btn-primary mt-4">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

