<?= $this->extend('layout/templateRegister'); ?>

<?= $this->section('content'); ?>
<div class="card shadow-lg form-signin">
    <div class="card-body p-5" >
        <h1 class="fs-4 card-title fw-bold mb-4"><?=$title;?></h1>
        <p><?=$message;?></p>
        <div class="d-flex aling-items-center ">
            <a href="<?=base_url();?>" class="btn btn-primary ms-auto">
                Iniciar Sesion
            </a>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>